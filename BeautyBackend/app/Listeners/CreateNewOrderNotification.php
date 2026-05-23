<?php

namespace App\Listeners;

use App\Models\AdminNotification;

class CreateNewOrderNotification
{
    public function handle(object $event): void
    {
        $order = $event->order;

        AdminNotification::create([
            'type' => 'new_order',
            'title' => "New Order #{$order->order_number}",
            'message' => "Order placed by {$order->shipping_first_name} {$order->shipping_last_name} — \${$order->total}",
            'link' => route('admin.orders.show', $order),
            'notifiable_id' => $order->id,
            'is_read' => false,
        ]);
    }
}
