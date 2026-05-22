<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#d4a5a5;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.total{font-size:16px;font-weight:700;text-align:right;padding-top:10px}.btn{display:inline-block;padding:10px 20px;background:#d4a5a5;color:#fff;text-decoration:none;border-radius:5px;margin-top:15px}</style></head>
<body>
<div class="container">
    <div class="header"><h1>Thank You for Your Order!</h1></div>
    <div class="content">
        <p>Hi <strong>{{ $order->shipping_first_name }}</strong>,</p>
        <p>Your order <strong>{{ $order->order_number }}</strong> has been placed successfully.</p>

        <table>
            <tr><th>Product</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>${{ number_format($item->product_price, 2) }}</td>
                <td>${{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </table>

        <div class="total">
            <p>Subtotal: ${{ number_format($order->subtotal, 2) }}</p>
            <p>Shipping: {{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE' }}</p>
            <p>Tax: ${{ number_format($order->tax, 2) }}</p>
            <p style="font-size:20px;">Total: ${{ number_format($order->total, 2) }}</p>
        </div>

        <p><strong>Shipping to:</strong><br>
        {{ $order->shipping_address }}<br>
        {{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>
        {{ $order->shipping_country }}</p>

        <p>Payment method: <strong>{{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}</strong></p>
        <p>Payment status: <strong>{{ ucfirst($order->payment_status) }}</strong></p>

        <p>We'll notify you when your order status changes. You can track your order anytime.</p>
        <p style="font-size:13px;color:#999;">If you have any questions, reply to this email or contact our support.</p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</div>
</body>
</html>
