<?php

namespace App\Listeners;

use App\Models\AdminNotification;

class CreateNewReviewNotification
{
    public function handle(object $event): void
    {
        $review = $event->review;

        $productName = $review->product?->name ?? 'a product';

        AdminNotification::create([
            'type' => 'new_review',
            'title' => 'New Review',
            'message' => "{$review->name} reviewed {$productName} — {$review->rating}★",
            'link' => route('admin.reviews.index'),
            'notifiable_id' => $review->id,
            'is_read' => false,
        ]);
    }
}
