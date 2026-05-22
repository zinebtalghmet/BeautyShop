<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#d4a5a5;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.status-badge{display:inline-block;padding:5px 15px;border-radius:12px;font-size:14px;font-weight:700}.status-pending{background:#fef3c7;color:#92400e}.status-confirmed{background:#dbeafe;color:#1e40af}.status-processing{background:#ede9fe;color:#5b21b6}.status-shipped{background:#f0fdf4;color:#166534}.status-delivered{background:#dcfce7;color:#166534}.status-cancelled{background:#fef2f2;color:#dc2626}</style></head>
<body>
<div class="container">
    <div class="header">
        @if($order->status === 'delivered')
            <h1>Your Order Has Arrived!</h1>
        @elseif($order->status === 'cancelled')
            <h1>Order Cancelled</h1>
        @elseif($order->status === 'shipped')
            <h1>Your Order Is On Its Way!</h1>
        @else
            <h1>Order Status Update</h1>
        @endif
    </div>
    <div class="content">
        <p>Hi <strong>{{ $order->shipping_first_name }}</strong>,</p>

        @if($order->status === 'delivered')
            <p>Your order <strong>{{ $order->order_number }}</strong> has been delivered. We hope you love your products!</p>
            <p>Thank you for shopping with us. If you have any feedback, we'd love to hear from you.</p>
        @elseif($order->status === 'cancelled')
            <p>Your order <strong>{{ $order->order_number }}</strong> has been cancelled.</p>
            @if($order->cancelled_reason)
                <p>Reason: {{ $order->cancelled_reason }}</p>
            @endif
            <p>If you have any questions, please contact our support team.</p>
        @elseif($order->status === 'shipped')
            <p>Your order <strong>{{ $order->order_number }}</strong> has been shipped and is on its way!</p>
        @else
            <p>Your order <strong>{{ $order->order_number }}</strong> status has been updated.</p>
        @endif

        <p style="text-align:center;margin:20px 0;">
            <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
        </p>

        <table>
            <tr><th>Product</th><th>Qty</th><th>Price</th></tr>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->product_price, 2) }}</td>
            </tr>
            @endforeach
        </table>

        <p style="font-size:13px;color:#999;">Thank you for choosing {{ config('app.name') }}!</p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</div>
</body>
</html>
