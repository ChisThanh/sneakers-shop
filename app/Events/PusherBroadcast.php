<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PusherBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public string $message;
    public string $sender_id;
    public string $receiver_id;

    public function __construct(string $message, int $sender_id, int $receiver_id)
    {
        $this->message = $message;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
    }

    public function broadcastOn()
    {
        return  ['user.' . $this->receiver_id];
    }
    public function broadcastAs(): string
    {
        return 'chat';
    }
}
