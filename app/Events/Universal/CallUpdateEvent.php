<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Universal;


use App\Call;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CallUpdateEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function broadcastOn()
    {
        return ['police.calls'];
    }

    public function broadcastAs() {
        return 'call.update';
    }

}