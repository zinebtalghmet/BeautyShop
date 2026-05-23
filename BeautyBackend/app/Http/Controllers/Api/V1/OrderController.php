<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\OrderPlaced;
use App\Http\Controllers\Controller;
use App\Mail\NewOrderNotification;
use App\Mail\OrderConfirmation;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\Setting;
use App\Services\ShippingCalculator;
use App\Services\TaxCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items')
            ->latest()
            ->paginate(10);

        return response()->json(['data' => $orders]);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }

        return response()->json(['data' => $order->load('items')]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'session_id' => 'required_without:auth|string|max:100',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100',
            'phone' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'country' => 'nullable|string|max:100',
            'region' => 'nullable|string|max:100',
            'payment_method' => 'required|string|in:card,cash_on_delivery',
        ]);

        $userId = $request->user()?->id;
        $ownerCol = $userId ? 'user_id' : 'session_id';
        $ownerVal = $userId ?? $validated['session_id'];

        $cartItems = CartItem::where($ownerCol, $ownerVal)
            ->with('product')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty.'], 400);
        }

        $order = DB::transaction(function () use ($cartItems, $validated, $userId) {
            $subtotal = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $shippingResult = ShippingCalculator::calculate($subtotal, $validated['country'] ?? 'US', $validated['region'] ?? null);
            $shipping = $shippingResult['cost'];

            $taxResult = TaxCalculator::calculate($subtotal, $validated['country'] ?? 'USA', $validated['region'] ?? null);
            $tax = $taxResult['amount'];

            $total = $subtotal + $shipping + $tax;

            $paymentStatus = $validated['payment_method'] === 'card' ? 'paid' : 'pending';

            $order = Order::create([
                'order_number' => 'BS-' . now()->format('Ymd') . '-' . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'user_id' => $userId,
                'status' => 'pending',
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $paymentStatus,
                'shipping_first_name' => $validated['first_name'],
                'shipping_last_name' => $validated['last_name'],
                'shipping_email' => $validated['email'],
                'shipping_phone' => $validated['phone'] ?? null,
                'shipping_address' => $validated['address'],
                'shipping_city' => $validated['city'],
                'shipping_state' => $validated['state'],
                'shipping_zip' => $validated['zip'],
                'shipping_country' => $validated['country'] ?? 'USA',
            ]);

            foreach ($cartItems as $cartItem) {
                $order->items()->create([
                    'product_id' => $cartItem->product_id,
                    'product_name' => $cartItem->product->name,
                    'product_price' => $cartItem->product->price,
                    'quantity' => $cartItem->quantity,
                    'subtotal' => $cartItem->product->price * $cartItem->quantity,
                ]);

                $cartItem->product->decrement('stock', $cartItem->quantity);
                $cartItem->delete();
            }

            return $order;
        });

        try {
            Mail::to($order->shipping_email)->send(new OrderConfirmation($order));
        } catch (\Throwable $e) {
            // log silently
        }

        try {
            $adminEmail = Setting::where('key', 'store_email')->value('value') ?: 'admin@beautyshop.com';
            Mail::to($adminEmail)->send(new NewOrderNotification($order));
        } catch (\Throwable $e) {
            // log silently
        }

        try {
            event(new OrderPlaced($order));
        } catch (\Throwable $e) {
            // log silently
        }

        return response()->json([
            'message' => 'Order placed successfully.',
            'data' => $order->load('items'),
        ], 201);
    }
}
