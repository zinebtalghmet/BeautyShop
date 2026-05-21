@extends('admin.layouts.admin')

@section('title', 'Products')

@section('content')
<div style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">Products</h1>
        <a href="{{ route('admin.products.create') }}"
           style="padding: 8px 16px; background: #e11d48; color: #fff; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">
            + New Product
        </a>
    </div>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filters -->
    <form method="GET" style="background: #fff; padding: 16px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); margin-bottom: 16px; display: flex; gap: 12px; align-items: end;">
        <div>
            <label style="font-size: 12px; font-weight: 500; color: #64748b; display: block; margin-bottom: 4px;">Search</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..."
                   style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; width: 220px; outline: none;">
        </div>
        <div>
            <label style="font-size: 12px; font-weight: 500; color: #64748b; display: block; margin-bottom: 4px;">Category</label>
            <select name="category" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; outline: none;">
                <option value="">All</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label style="font-size: 12px; font-weight: 500; color: #64748b; display: block; margin-bottom: 4px;">Status</label>
            <select name="status" style="padding: 8px 12px; border: 1px solid #e2e8f0; border-radius: 6px; font-size: 13px; outline: none;">
                <option value="">All</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <button type="submit" style="padding: 8px 16px; background: #0f172a; color: #fff; border: none; border-radius: 6px; font-size: 13px; cursor: pointer;">Filter</button>
    </form>

    <!-- Products Table -->
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Name</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Category</th>
                    <th style="padding: 12px 16px; text-align: right; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Price</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Stock</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Featured</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; font-weight: 500; color: #0f172a;">{{ $product->name }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #64748b;">{{ $product->category->name ?? '—' }}</td>
                        <td style="padding: 14px 16px; text-align: right; font-size: 14px; color: #0f172a;">${{ number_format($product->price, 2) }}</td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: {{ $product->stock > 5 ? '#166534' : ($product->stock > 0 ? '#d97706' : '#dc2626') }};">{{ $product->stock }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if ($product->is_featured)
                                <span style="color: #d97706;">★</span>
                            @else
                                <span style="color: #e2e8f0;">★</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if ($product->is_active)
                                <span style="display: inline-block; padding: 2px 10px; background: #dcfce7; color: #166534; border-radius: 12px; font-size: 12px; font-weight: 500;">Active</span>
                            @else
                                <span style="display: inline-block; padding: 2px 10px; background: #fef2f2; color: #dc2626; border-radius: 12px; font-size: 12px; font-weight: 500;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('admin.products.edit', $product) }}" style="color: #e11d48; text-decoration: none; font-size: 13px; font-weight: 500;">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $products->withQueryString()->links() }}
    </div>
</div>
@endsection
