<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show all chats for admin
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Chat::with(['user', 'admin', 'lastMessageSender']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $chats = $query->orderBy('last_message_at', 'desc')
            ->paginate(15);

        $stats = [
            'waiting' => Chat::waiting()->count(),
            'open' => Chat::open()->count(),
            'closed' => Chat::closed()->count(),
            'total' => Chat::count(),
        ];

        return view('admin.livechat.index', compact('chats', 'status', 'stats'));
    }

    /**
     * Show specific chat conversation
     */
    public function show($id)
    {
        $chat = Chat::with(['user', 'admin', 'messages.user'])->findOrFail($id);

        // Assign chat to admin if not assigned yet
        if (!$chat->admin_id) {
            $chat->assignAdmin(Auth::id());
        }

        $messages = $chat->messages()->with('user')->paginate(30);

        return view('admin.livechat.show', compact('chat', 'messages'));
    }

    /**
     * Send message from admin
     */
    public function sendMessage(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        // Only assigned admin or all admins can send
        if ($chat->admin_id && $chat->admin_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak bisa merespon chat ini.');
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $chat->addMessage(Auth::id(), $validated['message']);

        return redirect()->back()
            ->with('success', 'Pesan terkirim.');
    }

    /**
     * Close chat from admin side
     */
    public function close(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->admin_id && $chat->admin_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak bisa menutup chat ini.');
        }

        $message = $request->input('message');
        if ($message) {
            $chat->addMessage(Auth::id(), $message);
        }

        $chat->closeChat();

        return redirect()->route('admin.chat.index')
            ->with('success', 'Chat ditutup.');
    }

    /**
     * Assign chat to admin
     */
    public function assign(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        // Check if already assigned
        if ($chat->admin_id && $chat->admin_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Chat sudah diassign ke admin lain.');
        }

        $chat->assignAdmin(Auth::id());

        return redirect()->back()
            ->with('success', 'Chat telah diassign kepada Anda.');
    }

    /**
     * Unassign chat
     */
    public function unassign(Request $request, $id)
    {
        $chat = Chat::findOrFail($id);

        if ($chat->admin_id !== Auth::id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak menangani chat ini.');
        }

        $chat->update(['admin_id' => null, 'status' => 'waiting']);

        return redirect()->back()
            ->with('success', 'Chat telah di-unassign.');
    }

    /**
     * Get chats via AJAX (for real-time updates)
     */
    public function getChats(Request $request)
    {
        $status = $request->query('status', 'all');

        $query = Chat::with(['user', 'admin', 'lastMessageSender']);

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $chats = $query->orderBy('last_message_at', 'desc')->get();

        return response()->json($chats);
    }

    /**
     * Get specific chat messages via AJAX
     */
    public function getMessages($id)
    {
        $chat = Chat::with('messages.user')->findOrFail($id);

        return response()->json([
            'messages' => $chat->messages,
            'status' => $chat->status,
        ]);
    }

    /**
     * Get chat statistics
     */
    public function getStats()
    {
        $stats = [
            'waiting' => Chat::waiting()->count(),
            'open' => Chat::open()->count(),
            'closed' => Chat::closed()->count(),
            'total' => Chat::count(),
        ];

        return response()->json($stats);
    }
}
