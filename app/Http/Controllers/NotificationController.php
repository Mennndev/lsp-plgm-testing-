<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->paginate(20);
        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->markAsRead();

        if ($notification->link) {
            return redirect($notification->link);
        }

        return back()->with('success', 'Notifikasi ditandai sudah dibaca.');
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update([
            'is_read' => true,
            'read_at' => now(),
        ]);

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function destroy($id)
    {
        $notification = Notification::where('user_id', auth()->id())->findOrFail($id);
        $notification->delete();

        return back()->with('success', 'Notifikasi dihapus.');
    }

    // API endpoint untuk dropdown notifikasi
    public function getLatest()
    {
        $notifications = auth()->user()->notifications()->take(5)->get();
        $unreadCount = auth()->user()->unreadNotificationCount();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
        ]);
    }
}
