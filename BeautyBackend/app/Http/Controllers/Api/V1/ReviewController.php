<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\ReviewSubmitted;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Review::approved()->with('user:id,name');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        return response()->json([
            'data' => $query->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:200',
            'body' => 'nullable|string',
        ]);

        $review = Review::create([
            'product_id' => $validated['product_id'],
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'title' => $validated['title'] ?? null,
            'body' => $validated['body'] ?? null,
        ]);

        try {
            event(new ReviewSubmitted($review));
        } catch (\Throwable $e) {
            // log silently
        }

        return response()->json([
            'message' => 'Review submitted and pending approval.',
            'data' => $review,
        ], 201);
    }
}
