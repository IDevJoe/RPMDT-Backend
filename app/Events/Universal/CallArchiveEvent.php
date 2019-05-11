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

class CallArchiveEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $call;

    public function __construct(Call $call)
    {
        $this->call = $call;
    }

    public function broadcastOn()
    {
        return ['private-police.calls'];
    }

    public function broadcastAs() {
        return 'call.archive';
    }

}