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

class UnitDetachEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $unit;

    public function __construct(User $unit)
    {
        $this->unit = $unit;
    }

    public function broadcastOn()
    {
        return ['private-police.calls'];
    }

    public function broadcastAs() {
        return 'unit.detach';
    }

}