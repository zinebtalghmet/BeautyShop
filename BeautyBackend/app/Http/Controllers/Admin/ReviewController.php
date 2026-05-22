<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(Request $request): View
    {
        $query = Review::with('product:id,name', 'user:id,name');

        if ($request->filled('filter')) {
            $request->filter === 'approved'
                ? $query->approved()
                : $query->where('is_approved', false);
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review): RedirectResponse
    {
        $review->update(['is_approved' => true]);

        $review->product->increment('reviews_count');
        $avg = Review::approved()
            ->where('product_id', $review->product_id)
            ->avg('rating');
        $review->product->update(['rating' => round($avg, 1)]);

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review approved.');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->route('admin.reviews.index')
            ->with('success', 'Review deleted.');
    }
}
