<?php

namespace App\Providers;

use App\Events\ContactSubmitted;
use App\Events\OrderPlaced;
use App\Events\ReviewSubmitted;
use App\Listeners\CreateNewContactNotification;
use App\Listeners\CreateNewOrderNotification;
use App\Listeners\CreateNewReviewNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderPlaced::class => [CreateNewOrderNotification::class],
        ContactSubmitted::class => [CreateNewContactNotification::class],
        ReviewSubmitted::class => [CreateNewReviewNotification::class],
    ];
}
