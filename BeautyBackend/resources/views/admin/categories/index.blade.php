@extends('admin.layouts.admin')

@section('title', 'Categories')

@section('content')
<div style="padding: 24px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">Categories</h1>
        <a href="{{ route('admin.categories.create') }}"
           style="padding: 8px 16px; background: #e11d48; color: #fff; border-radius: 8px; text-decoration: none; font-size: 14px; font-weight: 600;">
            + New Category
        </a>
    </div>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Name</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Slug</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Products</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; font-weight: 500; color: #0f172a;">{{ $category->name }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #64748b;">{{ $category->slug }}</td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #475569;">{{ $category->products_count }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if ($category->is_active)
                                <span style="display: inline-block; padding: 2px 10px; background: #dcfce7; color: #166534; border-radius: 12px; font-size: 12px; font-weight: 500;">Active</span>
                            @else
                                <span style="display: inline-block; padding: 2px 10px; background: #fef2f2; color: #dc2626; border-radius: 12px; font-size: 12px; font-weight: 500;">Inactive</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('admin.categories.edit', $category) }}" style="color: #e11d48; text-decoration: none; font-size: 13px; font-weight: 500;">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">No categories found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">
        {{ $categories->links() }}
    </div>
</div>
@endsection
