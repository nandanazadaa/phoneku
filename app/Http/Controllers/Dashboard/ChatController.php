<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Show the customer chat interface.
     */
    public function customerChat()
    {
        Log::info('Authenticated user: ' . Auth::id() . ', Role: ' . Auth::user()->role);
        $support = User::where('role', 'admin')->first();

        if (!$support) {
            return redirect()->back()->with('error', 'No admin available to assist you.');
        }

        return view('home.user_chat', compact('support'));
    }

    /**
     * Show the support chat interface with all customer conversations.
     */
    public function index()
    {
        // Get all customers with active conversations
        $customers = User::where('role', 'customer')
            ->whereHas('sentMessages', function ($query) {
                $query->whereIn('receiver_id', User::where('role', 'admin')->pluck('id'))
                    ->orWhereIn('sender_id', User::where('role', 'admin')->pluck('id'));
            })
            ->with(['sentMessages' => function ($query) {
                $query->orderBy('created_at', 'desc')->first();
            }])
            ->get();

        return view('admin.admin_chat', compact('customers'));
    }

    /**
     * Fetch messages for a specific conversation.
     */
    public function fetchMessages($receiverId)
    {
        $receiver = User::findOrFail($receiverId);
    
        $isSenderCustomer = Auth::user()->role === 'customer';
        if ($isSenderCustomer && $receiver->role !== 'admin') {
            return response()->json(['error' => 'Customers can only message admins.'], 403);
        }
        if (!$isSenderCustomer && $receiver->role !== 'customer') {
            return response()->json(['error' => 'Admins can only message customers.'], 403);
        }
    
        $messages = Message::where(function ($query) use ($receiverId) {
            $query->where('sender_id', Auth::id())->where('receiver_id', $receiverId);
        })->orWhere(function ($query) use ($receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    
        Message::where('sender_id', $receiverId)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    
        $formattedMessages = $messages->map(function ($message) {
            return [
                'message' => $message->message,
                'is_sent' => $message->sender_id === Auth::id(),
                'created_at' => $message->created_at,
            ];
        });
    
        return response()->json($formattedMessages);
    }
    
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
        ]);
    
        $receiver = User::findOrFail($request->receiver_id);
        $isSenderCustomer = Auth::user()->role === 'customer';
        $isReceiverAdmin = $receiver->role === 'admin';
        $isReceiverCustomer = $receiver->role === 'customer';
    
        if ($isSenderCustomer && !$isReceiverAdmin) {
            return response()->json(['error' => 'Customers can only message admins.'], 403);
        }
        if (!$isSenderCustomer && !$isReceiverCustomer) {
            return response()->json(['error' => 'Admins can only message customers.'], 403);
        }
    
        $message = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);
    
        Log::info('Broadcasting message: ', [
            'sender_id' => $message->sender_id,
            'receiver_id' => $message->receiver_id,
            'message' => $message->message,
        ]);
    
        broadcast(new MessageSent(
            $message->sender_id,
            $message->receiver_id,
            $message->message,
            $message->created_at
        ))->toOthers();
    
        return response()->json([
            'message' => $message->message,
            'created_at' => $message->created_at,
        ]);
    }
}