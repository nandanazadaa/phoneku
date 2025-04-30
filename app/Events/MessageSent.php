<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender_id;
    public $receiver_id;
    public $message;
    public $created_at;

    public function __construct($sender_id, $receiver_id, $message, $created_at)
    {
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
        $this->message = $message;
        $this->created_at = $created_at;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('private-chat');
    }
}