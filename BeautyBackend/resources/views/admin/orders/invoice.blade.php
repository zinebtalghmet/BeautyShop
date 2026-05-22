<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice — {{ $order->order_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Courier New', monospace; font-size: 12px; padding: 40px; color: #1e293b; }
        .header { text-align: center; margin-bottom: 32px; }
        .header h1 { font-size: 24px; letter-spacing: 2px; }
        .header span { color: #e11d48; }
        .header p { color: #64748b; margin-top: 4px; }
        .info { display: flex; justify-content: space-between; margin-bottom: 24px; }
        .info div { width: 45%; }
        .info h3 { font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; margin-bottom: 4px; }
        .info p { font-size: 12px; line-height: 1.6; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        th { background: #f8fafc; padding: 8px 12px; text-align: left; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #64748b; border-bottom: 2px solid #e2e8f0; }
        td { padding: 8px 12px; border-bottom: 1px solid #f1f5f9; font-size: 12px; }
        .totals { width: 300px; margin-left: auto; }
        .totals > div { display: flex; justify-content: space-between; padding: 4px 0; font-size: 12px; }
        .totals .grand { font-weight: 700; font-size: 14px; border-top: 2px solid #1e293b; padding-top: 8px; margin-top: 4px; }
        .footer { text-align: center; color: #94a3b8; font-size: 10px; margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 16px; }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>BEAUTY<span>·</span></h1>
        <p>Invoice</p>
    </div>

    <div class="info">
        <div>
            <h3>Bill To</h3>
            <p>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br>{{ $order->shipping_email }}<br>{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
        </div>
        <div style="text-align: right;">
            <h3>Invoice #</h3>
            <p>{{ $order->order_number }}<br>{{ $order->created_at->format('F d, Y') }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr><th>Product</th><th>Price</th><th>Qty</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr><td>{{ $item->product_name }}</td><td>${{ number_format($item->product_price, 2) }}</td><td>{{ $item->quantity }}</td><td>${{ number_format($item->subtotal, 2) }}</td></tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div><span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span></div>
        <div><span>Shipping</span><span>{{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE' }}</span></div>
        <div><span>Tax</span><span>${{ number_format($order->tax, 2) }}</span></div>
        <div class="grand"><span>Total</span><span>${{ number_format($order->total, 2) }}</span></div>
    </div>

    <div class="footer">
        <p>Thank you for shopping with BeautyShop!</p>
    </div>
</body>
</html>
