<?php

namespace App\Events;

use App\Models\Review;
use Illuminate\Foundation\Events\Dispatchable;

class ReviewSubmitted
{
    use Dispatchable;

    public Review $review;

    public function __construct(Review $review)
    {
        $this->review = $review;
    }
}
