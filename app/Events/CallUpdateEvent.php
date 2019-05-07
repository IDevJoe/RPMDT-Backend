<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CallUpdateEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $call;
    public $server;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($call, $server)
    {
        $this->call = $call;
        $this->server = $server;
    }

    public function broadcastOn()
    {
        return ['calls.' . $this->server->id];
    }

    public function broadcastAs() {
        return 'call.update';
    }
}
