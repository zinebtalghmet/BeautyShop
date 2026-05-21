<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ProductResource;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::active()->with('category', 'images');

        // Category filter
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // Featured filter
        if ($request->boolean('featured')) {
            $query->featured();
        }

        // In stock filter
        if ($request->boolean('in_stock')) {
            $query->inStock();
        }

        // Price range filter
        if ($request->filled('min_price')) {
            $query->priceBetween(
                (float) $request->min_price,
                (float) ($request->max_price ?? 999999)
            );
        }

        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Sorting
        match ($request->sort) {
            'price_low' => $query->orderBy('price'),
            'price_high' => $query->orderBy('price', 'desc'),
            'name_asc' => $query->orderBy('name'),
            'rating' => $query->orderBy('rating', 'desc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc'),
        };

        $perPage = min((int) $request->per_page, 48, 48);
        $perPage = max($perPage ?: 9, 1);

        $products = $query->paginate($perPage);

        return response()->json([
            'data' => ProductResource::collection($products),
            'meta' => [
                'total' => $products->total(),
                'per_page' => $products->perPage(),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
            ],
        ]);
    }

    public function featured(): JsonResponse
    {
        $products = Product::active()
            ->featured()
            ->with('category', 'images')
            ->limit(8)
            ->get();

        return response()->json([
            'data' => ProductResource::collection($products),
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::active()
            ->with('category', 'images')
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json([
            'data' => new ProductResource($product),
        ]);
    }
}
