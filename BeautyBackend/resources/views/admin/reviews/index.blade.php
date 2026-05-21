@extends('admin.layouts.admin')

@section('title', 'Reviews')

@section('content')
<div style="padding: 24px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">Reviews</h1>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <div style="display: flex; gap: 8px; margin-bottom: 16px;">
        @php $filters = ['' => 'All', 'pending' => 'Pending', 'approved' => 'Approved']; @endphp
        @foreach ($filters as $val => $label)
            <a href="{{ request()->fullUrlWithQuery(['filter' => $val ?: null]) }}"
               style="padding: 6px 14px; border-radius: 20px; font-size: 13px; text-decoration: none; {{ request('filter', '') === $val ? 'background: #e11d48; color: #fff;' : 'background: #f1f5f9; color: #475569;' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Product</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Customer</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Rating</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Review</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reviews as $review)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 14px 16px; font-size: 14px; color: #0f172a;">{{ $review->product->name ?? '—' }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">{{ $review->user->name ?? 'Guest' }}</td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 14px; color: #d97706;">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569; max-width: 250px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $review->body ?: $review->title ?: '—' }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if ($review->is_approved)
                                <span style="display: inline-block; padding: 2px 10px; background: #dcfce7; color: #166534; border-radius: 12px; font-size: 12px;">Approved</span>
                            @else
                                <span style="display: inline-block; padding: 2px 10px; background: #fef3c7; color: #92400e; border-radius: 12px; font-size: 12px;">Pending</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if (!$review->is_approved)
                                <a href="{{ route('admin.reviews.approve', $review) }}" style="color: #166534; text-decoration: none; font-size: 13px; font-weight: 500; margin-right: 8px;">Approve</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">No reviews found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">{{ $reviews->withQueryString()->links() }}</div>
</div>
@endsection
