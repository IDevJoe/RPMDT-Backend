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

class CallsignChangeEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $user;
    public $newCallsign;

    public function __construct(User $user, Callsign $newCallsign)
    {
        $this->user = $user->setHidden(['email']);
        $this->newCallsign = $newCallsign;
    }

    public function broadcastOn()
    {
        return ['police'];
    }

    public function broadcastAs() {
        return 'user.callsignchange';
    }

}