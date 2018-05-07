<?php

namespace App\Events\Whmcs;

use App\WhmcsHook;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Hook
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $hook;
    public $payload;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(WhmcsHook $hook)
    {
        $this->hook = $hook;
        $this->payload = $hook->payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
