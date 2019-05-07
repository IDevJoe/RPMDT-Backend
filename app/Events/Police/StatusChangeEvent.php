<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Police;


use App\Callsign;
use App\Events\Event;
use App\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class StatusChangeEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $newStatus;

    public function __construct(User $user, $newStatus)
    {
        $this->user = $user->setHidden(['email']);
        $this->newStatus = $newStatus;
    }

    public function broadcastOn()
    {
        return ['police'];
    }

    public function broadcastAs() {
        return 'user.statuschange';
    }

}