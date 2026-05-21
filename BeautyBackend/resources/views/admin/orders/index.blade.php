@extends('admin.layouts.admin')

@section('title', 'Orders')

@section('content')
<div style="padding: 24px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">Orders</h1>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Status Tabs -->
    <div style="display: flex; gap: 8px; margin-bottom: 16px; flex-wrap: wrap;">
        @php $statuses = ['' => 'All', 'pending' => 'Pending', 'confirmed' => 'Confirmed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'delivered' => 'Delivered', 'cancelled' => 'Cancelled']; @endphp
        @foreach ($statuses as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['status' => $val === 'All' ? '' : $val, 'page' => null]) }}"
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ request('status', '') === $val ? 'background: #e11d48; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <!-- Search -->
    <form method="GET" style="background: #fff; padding: 16px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 16px; display: flex; gap: 12px;">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by order #, name, or email..."
               style="flex: 1; padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; outline: none;">
        @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
        <button type="submit" style="padding: 8px 16px; background: #0f172a; color: #fff; border: none; border-radius: 6px; font-size: 13px; cursor: pointer;">Search</button>
    </form>

    <!-- Orders Table -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Order #</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Customer</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Items</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Total</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Date</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; font-weight: 600; color: #0f172a;">{{ $order->order_number }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}<br><span style="color: #94a3b8;">{{ $order->shipping_email }}</span></td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;">{{ $order->items_count }}</td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 14px; font-weight: 600; color: #0f172a;">${{ number_format($order->total, 2) }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <span style="display: inline-block; padding: 2px 10px; border-radius: 12px; font-size: 12px; font-weight: 500;
                                {{ $order->status === 'pending' ? 'background: #fef3c7; color: #92400e;' : '' }}
                                {{ $order->status === 'confirmed' ? 'background: #dbeafe; color: #1e40af;' : '' }}
                                {{ $order->status === 'processing' ? 'background: #ede9fe; color: #5b21b6;' : '' }}
                                {{ $order->status === 'shipped' ? 'background: #f0fdf4; color: #166534;' : '' }}
                                {{ $order->status === 'delivered' ? 'background: #dcfce7; color: #166534;' : '' }}
                                {{ $order->status === 'cancelled' ? 'background: #fef2f2; color: #dc2626;' : '' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 13px; color: #64748b;">{{ $order->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('admin.orders.show', $order) }}" style="color: #e11d48; text-decoration: none; font-size: 13px; font-weight: 500;">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">No orders found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">{{ $orders->withQueryString()->links() }}</div>
</div>
@endsection
