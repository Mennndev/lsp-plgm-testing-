<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show live chat page for user
     */
    public function index()
    {
        $chats = Chat::byUser(Auth::id())
            ->orderBy('last_message_at', 'desc')
            ->paginate(10);

        return view('livechat.index', compact('chats'));
    }

    /**
     * Show specific chat conversation
     */
    public function show($id)
    {
        $chat = Chat::byUser(Auth::id())->findOrFail($id);
        $messages = $chat->messages()->paginate(20);

        return view('livechat.show', compact('chat', 'messages'));
    }

    /**
     * Start new chat
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $chat = Chat::create([
            'user_id' => Auth::id(),
            'subject' => $validated['subject'],
            'status' => 'waiting',
        ]);

        // Add first message
        $chat->addMessage(Auth::id(), $validated['message']);

        return redirect()->route('chat.show', $chat->id)
            ->with('success', 'Chat dimulai. Silakan tunggu admin untuk merespon.');
    }

    /**
     * Send message in chat
     */
    public function sendMessage(Request $request, $id)
    {
        $chat = Chat::byUser(Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        if ($chat->status === 'closed') {
            return redirect()->back()
                ->with('error', 'Chat sudah ditutup.');
        }

        $chat->addMessage(Auth::id(), $validated['message']);

        return redirect()->back()
            ->with('success', 'Pesan terkirim.');
    }

    /**
     * Close chat from user side
     */
    public function close($id)
    {
        $chat = Chat::byUser(Auth::id())->findOrFail($id);
        $chat->closeChat();

        return redirect()->route('chat.index')
            ->with('success', 'Chat ditutup.');
    }

    /**
     * Get chat list via AJAX (for real-time updates)
     */
    public function getChats()
    {
        $chats = Chat::byUser(Auth::id())
            ->with(['admin', 'lastMessageSender'])
            ->orderBy('last_message_at', 'desc')
            ->get();

        return response()->json($chats);
    }

    /**
     * Get messages for specific chat via AJAX
     */
    public function getMessages($id)
    {
        $chat = Chat::byUser(Auth::id())->findOrFail($id);
        $messages = $chat->messages()->with('user')->get();

        return response()->json([
            'messages' => $messages,
            'status' => $chat->status,
        ]);
    }
}
