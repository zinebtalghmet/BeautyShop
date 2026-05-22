<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = CartItem::with('product.images');

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        } else {
            return response()->json(['data' => []]);
        }

        return response()->json(['data' => $query->get()]);
    }

    public function add(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'session_id' => 'required_without:auth|string|max:100',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $ownerCol = $request->user() ? 'user_id' : 'session_id';
        $ownerVal = $request->user()?->id ?? $validated['session_id'];

        $existing = CartItem::where($ownerCol, $ownerVal)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $validated['variant_id'] ?? null)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $validated['quantity']);
            $item = $existing;
        } else {
            $item = CartItem::create([
                $ownerCol => $ownerVal,
                'product_id' => $product->id,
                'product_variant_id' => $validated['variant_id'] ?? null,
                'quantity' => $validated['quantity'],
            ]);
        }

        $item->load('product.images');

        return response()->json(['message' => 'Item added to cart.', 'data' => $item], 201);
    }

    public function updateQuantity(Request $request, CartItem $cartItem): JsonResponse
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $this->authorizeAccess($request, $cartItem);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return response()->json(['message' => 'Cart updated.', 'data' => $cartItem->fresh()->load('product.images')]);
    }

    public function remove(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->authorizeAccess($request, $cartItem);
        $cartItem->delete();

        return response()->json(['message' => 'Item removed from cart.']);
    }

    public function clear(Request $request): JsonResponse
    {
        $query = CartItem::query();

        if ($request->user()) {
            $query->where('user_id', $request->user()->id);
        } elseif ($request->has('session_id')) {
            $query->where('session_id', $request->session_id);
        } else {
            return response()->json(['message' => 'No cart to clear.'], 400);
        }

        $query->delete();

        return response()->json(['message' => 'Cart cleared.']);
    }

    private function authorizeAccess(Request $request, CartItem $cartItem): void
    {
        if ($request->user() && $cartItem->user_id !== $request->user()->id) {
            abort(403, 'Unauthorized.');
        }
    }
}
