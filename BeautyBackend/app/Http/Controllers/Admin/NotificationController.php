<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(): View
    {
        $notifications = AdminNotification::recent()->paginate(20);
        return view('admin.notifications.index', compact('notifications'));
    }

    public function fetch(): JsonResponse
    {
        $unreadCount = AdminNotification::unread()->count();
        $notifications = AdminNotification::recent()->take(10)->get();

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    public function markAsRead(AdminNotification $notification): JsonResponse
    {
        $notification->update(['is_read' => true]);
        return response()->json(['message' => 'Marked as read.']);
    }

    public function markAllRead(): JsonResponse
    {
        AdminNotification::unread()->update(['is_read' => true]);
        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
