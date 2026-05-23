<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice — {{ $order->order_number }}</title>
    <style>
        @page { margin: 32px 40px; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            font-size: 10px;
            line-height: 1.5;
            color: #1e293b;
            background: #fff;
        }

        .invoice-wrap {
            max-width: 720px;
            margin: 0 auto;
            padding: 48px 0;
        }

        /* ── Top Bar ── */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 24px;
            border-bottom: 2px solid #f1f5f9;
            margin-bottom: 32px;
        }
        .brand h1 {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #0f172a;
        }
        .brand h1 span { color: #e11d48; }
        .brand p {
            font-size: 10px;
            color: #64748b;
            margin-top: 2px;
        }
        .badge {
            display: inline-block;
            background: #e11d48;
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            padding: 4px 14px;
            border-radius: 4px;
        }

        /* ── Meta Row ── */
        .meta-row {
            display: flex;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 36px;
        }
        .meta-col h3 {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
            margin-bottom: 6px;
        }
        .meta-col p {
            font-size: 10px;
            color: #334155;
            line-height: 1.6;
        }
        .meta-col .status {
            display: inline-block;
            font-size: 9px;
            font-weight: 600;
            text-transform: capitalize;
            padding: 2px 10px;
            border-radius: 3px;
        }
        .meta-col .status.completed { background: #dcfce7; color: #166534; }
        .meta-col .status.pending { background: #fef9c3; color: #854d0e; }
        .meta-col .status.processing { background: #dbeafe; color: #1e40af; }
        .meta-col .status.cancelled { background: #fecaca; color: #991b1b; }
        .meta-col .status.shipped { background: #e0e7ff; color: #3730a3; }

        /* ── Divider ── */
        .divider { border: none; border-top: 1px solid #e2e8f0; margin-bottom: 36px; }

        /* ── Addresses ── */
        .addresses {
            display: flex;
            gap: 48px;
            margin-bottom: 36px;
        }
        .address-block { flex: 1; }
        .address-block h3 {
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
            margin-bottom: 8px;
        }
        .address-block .name {
            font-size: 11px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .address-block p {
            font-size: 10px;
            color: #475569;
            line-height: 1.6;
        }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 28px;
        }
        thead th {
            background: #f8fafc;
            padding: 10px 14px;
            text-align: left;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        thead th:last-child { text-align: right; }
        thead th:nth-child(2),
        thead th:nth-child(3) { text-align: center; }
        tbody td {
            padding: 12px 14px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 10px;
            color: #334155;
        }
        tbody tr:last-child td { border-bottom: none; }
        tbody td:last-child { text-align: right; font-weight: 600; }
        tbody td:nth-child(2) { text-align: center; }
        tbody td:nth-child(3) { text-align: center; }

        /* ── Totals ── */
        .totals-wrap {
            width: 280px;
            margin-left: auto;
            padding: 20px 24px;
            background: #f8fafc;
            border-radius: 6px;
        }
        .totals-wrap .row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            font-size: 10px;
            color: #475569;
        }
        .totals-wrap .row.grand {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            border-top: 2px solid #cbd5e1;
            padding-top: 10px;
            margin-top: 4px;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            padding-top: 24px;
            margin-top: 40px;
            border-top: 1px solid #e2e8f0;
        }
        .footer p {
            font-size: 9px;
            color: #94a3b8;
            line-height: 1.6;
        }
        .footer .strong { color: #64748b; font-weight: 600; }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="invoice-wrap">

        {{-- Top Bar --}}
        <div class="top-bar">
            <div class="brand">
                <h1>BEAUTY<span>·</span></h1>
                <p>{{ $settings['store_address'] ?? '' }}</p>
            </div>
            <div class="badge">Invoice</div>
        </div>

        {{-- Meta Row --}}
        <div class="meta-row">
            <div class="meta-col">
                <h3>Invoice Number</h3>
                <p>{{ $order->order_number }}</p>
            </div>
            <div class="meta-col">
                <h3>Invoice Date</h3>
                <p>{{ $order->created_at->format('F d, Y') }}</p>
            </div>
            <div class="meta-col">
                <h3>Payment</h3>
                <p>{{ ucfirst($order->payment_method) }} — <span class="status {{ $order->payment_status }}">{{ $order->payment_status }}</span></p>
            </div>
            <div class="meta-col">
                <h3>Order Status</h3>
                <p><span class="status {{ $order->status }}">{{ $order->status }}</span></p>
            </div>
        </div>

        <hr class="divider">

        {{-- Addresses --}}
        <div class="addresses">
            <div class="address-block">
                <h3>Bill To</h3>
                <p class="name">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</p>
                <p>{{ $order->shipping_email }}</p>
                <p>{{ $order->shipping_address }}</p>
                <p>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}</p>
                @if ($order->shipping_phone)
                    <p>{{ $order->shipping_phone }}</p>
                @endif
            </div>
            <div class="address-block">
                <h3>Sold By</h3>
                <p class="name">{{ $settings['store_name'] ?? 'BeautyShop' }}</p>
                <p>{{ $settings['store_email'] ?? '' }}</p>
                <p>{{ $settings['store_phone'] ?? '' }}</p>
            </div>
        </div>

        {{-- Items Table --}}
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td>${{ number_format($item->product_price, 2) }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Totals --}}
        <div class="totals-wrap">
            <div class="row">
                <span>Subtotal</span>
                <span>${{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="row">
                <span>Shipping</span>
                <span>{{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE' }}</span>
            </div>
            <div class="row">
                <span>Tax</span>
                <span>${{ number_format($order->tax, 2) }}</span>
            </div>
            @if ($order->discount_amount > 0)
                <div class="row">
                    <span>Discount</span>
                    <span>-${{ number_format($order->discount_amount, 2) }}</span>
                </div>
            @endif
            <div class="row grand">
                <span>Total</span>
                <span>${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        {{-- Footer --}}
        <div class="footer">
            <p class="strong">{{ $settings['store_name'] ?? 'BeautyShop' }}</p>
            <p>{{ $settings['store_email'] ?? '' }} &bull; {{ $settings['store_phone'] ?? '' }}</p>
            <p>Thank you for your purchase!</p>
        </div>

    </div>
</body>
</html>
