<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show the admin chat interface.
     */
    public function index()
    {
        // Get all customers (non-admin users)
        $customers = User::where('is_admin', false)->get();
        
        return view('admin.admin_chat', compact('customers'));
    }
    
    /**
     * Show the customer chat interface.
     */
    public function customerChat()
    {
        // Get admin user for display
        $admin = User::where('is_admin', true)->first();
        $customers = User::where('is_admin', false)->get();
        
        return view('home.user_chat', compact('admin','customers'));
    }
    
    /**
     * Fetch messages for a specific conversation.
     */
    public function fetchMessages($receiverId)
    {
        // Validate receiver exists
        if (!User::find($receiverId)) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Get messages between the current user and the specified receiver
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
        
        // Mark received messages as read
        Message::where('sender_id', $receiverId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
        
        // Format messages for frontend
        $formattedMessages = [];
        foreach ($messages as $message) {
            $formattedMessages[] = [
                'message' => $message->message,
                'is_sent' => $message->sender_id === Auth::id(),
                'created_at' => $message->created_at
            ];
        }
        
        return response()->json($formattedMessages);
    }
    
    /**
     * Send a new message.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id'
        ]);
        
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false
        ]);
        
        // Broadcast the message
        broadcast(new MessageSent(
            $message->sender_id,
            $message->receiver_id,
            $message->message,
            $message->created_at
        ))->toOthers();
        
        return response()->json([
            'message' => $message->message,
            'created_at' => $message->created_at
        ]);
    }

    /**
     * Store feedback for a message (optional).
     */
    public function storeFeedback(Request $request)
    {
        $request->validate([
            'message_id' => 'required|exists:messages,id',
            'feedback' => 'required|in:positive,negative'
        ]);

        // Implement feedback storage logic here (e.g., save to a feedback table)
        return response()->json(['message' => 'Feedback recorded']);
    }
}