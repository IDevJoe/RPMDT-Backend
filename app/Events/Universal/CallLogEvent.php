<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Universal;


use App\Call;
use App\CallLog;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CallLogEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $log;

    public function __construct(CallLog $log)
    {
        $this->log = $log;
    }

    public function broadcastOn()
    {
        return ['private-police.calls'];
    }

    public function broadcastAs() {
        return 'call.log';
    }

}