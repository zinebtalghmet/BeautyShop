<!DOCTYPE html>
<html>
<head><meta charset="utf-8"><style>body{font-family:Arial,sans-serif;color:#333;line-height:1.6;margin:0;padding:0}.container{max-width:600px;margin:0 auto;padding:20px}.header{background:#0f172a;color:#fff;padding:20px;text-align:center;border-radius:8px 8px 0 0}.header h1{margin:0;font-size:22px}.content{padding:20px;background:#f9f9f9;border:1px solid #e0e0e0;border-top:none}.footer{padding:15px;text-align:center;font-size:12px;color:#999}table{width:100%;border-collapse:collapse;margin:15px 0}th,td{padding:10px 12px;text-align:left;border-bottom:1px solid #e0e0e0}th{background:#f0f0f0;font-size:13px}.total{font-size:16px;font-weight:700;text-align:right;padding-top:10px}.label{display:inline-block;padding:3px 10px;border-radius:10px;font-size:12px;font-weight:600;background:#fef3c7;color:#92400e}</style></head>
<body>
<div class="container">
    <div class="header"><h1>New Order Received</h1></div>
    <div class="content">
        <p>A new order has been placed.</p>
        <p><strong>Order:</strong> {{ $order->order_number }} <span class="label">{{ ucfirst($order->status) }}</span></p>
        <p><strong>Customer:</strong> {{ $order->shipping_first_name }} {{ $order->shipping_last_name }} ({{ $order->shipping_email }})</p>
        <p><strong>Payment:</strong> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }} - {{ ucfirst($order->payment_status) }}</p>

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
            <p>Total: ${{ number_format($order->total, 2) }}</p>
        </div>

        <p><a href="{{ url('/admin/orders/'.$order->id) }}" style="color:#d4a5a5;">View order in admin &rarr;</a></p>
    </div>
    <div class="footer">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</div>
</div>
</body>
</html>
