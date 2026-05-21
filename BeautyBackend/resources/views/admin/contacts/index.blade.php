@extends('admin.layouts.admin')

@section('title', 'Contacts')

@section('content')
<div style="padding: 24px;">
    <h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin-bottom: 24px;">Contact Messages</h1>

    @if (session('success'))
        <div style="background: #f0fdf4; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px;">{{ session('success') }}</div>
    @endif

    <div style="background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Name</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Email</th>
                    <th style="padding: 12px 16px; text-align: left; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Subject</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Status</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Date</th>
                    <th style="padding: 12px 16px; text-align: center; font-size: 12px; font-weight: 600; color: #64748b; text-transform: uppercase;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr style="border-bottom: 1px solid #f1f5f9; {{ !$contact->is_read ? 'background: #f8fafc;' : '' }}">
                        <td style="padding: 14px 16px; font-size: 14px; font-weight: {{ !$contact->is_read ? '600' : '400' }}; color: #0f172a;">{{ $contact->name }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">{{ $contact->email }}</td>
                        <td style="padding: 14px 16px; font-size: 13px; color: #475569;">{{ $contact->subject }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            @if ($contact->is_read)
                                <span style="display: inline-block; padding: 2px 10px; background: #f1f5f9; color: #64748b; border-radius: 12px; font-size: 12px;">Read</span>
                            @else
                                <span style="display: inline-block; padding: 2px 10px; background: #dbeafe; color: #1e40af; border-radius: 12px; font-size: 12px; font-weight: 500;">New</span>
                            @endif
                        </td>
                        <td style="padding: 14px 16px; text-align: center; font-size: 13px; color: #64748b;">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td style="padding: 14px 16px; text-align: center;">
                            <a href="{{ route('admin.contacts.show', $contact) }}" style="color: #e11d48; text-decoration: none; font-size: 13px;">View</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" style="padding: 40px; text-align: center; color: #94a3b8; font-size: 14px;">No messages yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top: 16px;">{{ $contacts->links() }}</div>
</div>
@endsection
