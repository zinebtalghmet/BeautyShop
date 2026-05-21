@extends('admin.layouts.admin')

@section('title', 'Contact Message')

@section('content')
<div style="padding: 24px; max-width: 640px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h1 style="font-size: 24px; font-weight: 700; color: #0f172a;">Message from {{ $contact->name }}</h1>
        <a href="{{ route('admin.contacts.index') }}" style="padding: 8px 16px; background: #f1f5f9; color: #475569; border-radius: 8px; text-decoration: none; font-size: 13px;">← Back</a>
    </div>

    <div style="background: #fff; padding: 24px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px; padding-bottom: 16px; border-bottom: 1px solid #e2e8f0;">
            <div><strong style="font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px;">Name</strong><span style="font-size: 14px; color: #0f172a;">{{ $contact->name }}</span></div>
            <div><strong style="font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px;">Email</strong><span style="font-size: 14px; color: #0f172a;">{{ $contact->email }}</span></div>
            <div><strong style="font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px;">Subject</strong><span style="font-size: 14px; color: #0f172a;">{{ $contact->subject }}</span></div>
            <div><strong style="font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px;">Date</strong><span style="font-size: 14px; color: #0f172a;">{{ $contact->created_at->format('F d, Y \a\t g:i A') }}</span></div>
        </div>
        <div>
            <strong style="font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 8px;">Message</strong>
            <p style="font-size: 14px; color: #334155; line-height: 1.7;">{{ $contact->message }}</p>
        </div>
    </div>
</div>
@endsection
