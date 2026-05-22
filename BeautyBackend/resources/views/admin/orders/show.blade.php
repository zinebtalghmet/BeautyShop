@extends('admin.layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
<div style="padding: 24px; max-width: 900px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">Order {{ $order->order_number }}</h1>
            <p style="color: #64748b; font-size: 14px;">Placed {{ $order->created_at->format('F d, Y \a\t g:i A') }}</p>
        </div>
        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" style="padding: 8px 16px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 13px;">Print Invoice</a>
    </div>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px;">
        <!-- Status Update -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Status</h3>
            <span style="display: inline-block; padding: 4px 14px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 12px;
                {{ $order->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : '' }}
                {{ $order->status === 'confirmed' ? 'background: #dbeafe; color: #1e40af;' : '' }}
                {{ $order->status === 'processing' ? 'background: #ede9fe; color: #5b21b6;' : '' }}
                {{ $order->status === 'shipped' ? 'background: #f0fdf4; color: #166534;' : '' }}
                {{ $order->status === 'delivered' ? 'background: #dcfce7; color: #166534;' : '' }}
                {{ $order->status === 'cancelled' ? 'background: #fef2f2; color: #dc2626;' : '' }}">
                {{ ucfirst($order->status) }}
            </span>
            @if (!in_array($order->status, ['delivered', 'cancelled']))
                <form method="POST" action="{{ route('admin.orders.status', $order) }}" style="display: flex; gap: 8px;">
                    @csrf
                    @method('PUT')
                    <select name="status" style="flex: 1; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px;">
                        @php $next = ['pending' => ['confirmed', 'cancelled'], 'confirmed' => ['processing', 'cancelled'], 'processing' => ['shipped', 'cancelled'], 'shipped' => ['delivered']]; @endphp
                        @foreach ($next[$order->status] ?? [] as $s)
                            <option value="{{ $s }}">{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" style="padding: 8px 16px; background: #0f172a; color: #fff; border: none; border-radius: 6px; font-size: 13px; cursor: pointer;">Update</button>
                </form>
            @endif
        </div>

        <!-- Customer Info -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Customer</h3>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;"><strong>{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}</strong></p>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;">{{ $order->shipping_email }}</p>
            @if ($order->shipping_phone) <p style="font-size: 13px; color: #475569; margin-bottom: 4px;">{{ $order->shipping_phone }}</p> @endif
        </div>

        <!-- Shipping -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Shipping Address</h3>
            <p style="font-size: 13px; color: #475569;">{{ $order->shipping_address }}<br>{{ $order->shipping_city }}, {{ $order->shipping_state }} {{ $order->shipping_zip }}<br>{{ $order->shipping_country }}</p>
        </div>

        <!-- Payment -->
        <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
            <h3 style="font-size: 14px; font-weight: 600; color: #0f172a; margin-bottom: 12px;">Payment</h3>
            <p style="font-size: 13px; color: #475569; margin-bottom: 4px;">Method: <strong>{{ strtoupper($order->payment_method) }}</strong></p>
            <p style="font-size: 13px; color: #475569;">Status: <strong>{{ ucfirst($order->payment_status) }}</strong></p>
        </div>
    </div>

    <!-- Order Items -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden; margin-bottom: 20px;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Product</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Price</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Qty</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; color: #0f172a;">{{ $item->product_name }}</td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;">${{ number_format($item->product_price, 2) }}</td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;">{{ $item->quantity }}</td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 14px; color: #0f172a;">${{ number_format($item->subtotal, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div style="background: #fff; padding: 20px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-left: auto; width: 320px;">
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Subtotal</span><span>${{ number_format($order->subtotal, 2) }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Shipping</span><span>{{ $order->shipping_cost > 0 ? '$'.number_format($order->shipping_cost, 2) : 'FREE' }}</span>
        </div>
        <div style="display: flex; justify-content: space-between; font-size: 14px; color: #475569; margin-bottom: 8px;">
            <span>Tax</span><span>${{ number_format($order->tax, 2) }}</span>
        </div>
        <hr style="border: none; border-top: 1px solid #e2e8f0; margin: 8px 0;">
        <div style="display: flex; justify-content: space-between; font-size: 16px; font-weight: 700; color: #0f172a;">
            <span>Total</span><span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>
</div>
@endsection
