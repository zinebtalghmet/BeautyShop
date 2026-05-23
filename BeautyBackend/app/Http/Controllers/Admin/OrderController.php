<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdate;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::withCount('items');

        if ($request->filled('status')) {
            $query->byStatus($request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('shipping_email', 'like', "%{$search}%")
                  ->orWhere('shipping_first_name', 'like', "%{$search}%")
                  ->orWhere('shipping_last_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load('items', 'user');

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,processing,shipped,delivered,cancelled',
        ]);

        $timestamps = [];
        if ($validated['status'] === 'shipped') {
            $timestamps['shipped_at'] = now();
        }
        if ($validated['status'] === 'delivered') {
            $timestamps['delivered_at'] = now();
        }
        if ($validated['status'] === 'cancelled') {
            $timestamps['cancelled_at'] = now();
            $timestamps['cancelled_reason'] = $request->input('reason');
        }

        $order->update(array_merge(['status' => $validated['status']], $timestamps));
        $order->load('items');

        try {
            Mail::to($order->shipping_email)->send(new OrderStatusUpdate($order));
        } catch (\Throwable $e) {
            // log silently
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', "Order {$order->order_number} status updated to {$validated['status']}.");
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', "Order {$order->order_number} deleted successfully.");
    }

    public function invoice(Order $order): View
    {
        $order->load('items');
        $settings = Setting::pluck('value', 'key');
        return view('admin.orders.invoice', compact('order', 'settings'));
    }
}
