<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Universal;


use App\Call;
use App\Events\Event;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CallAssignEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $call;
    public $unit;

    public function __construct(Call $call, User $unit)
    {
        $this->call = $call;
        $this->unit = $unit;
    }

    public function broadcastOn()
    {
        return ['police.calls'];
    }

    public function broadcastAs() {
        return 'call.assign';
    }

}