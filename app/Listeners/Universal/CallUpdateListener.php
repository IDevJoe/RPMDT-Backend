<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Listeners\Universal;


use App\CallLog;
use App\Events\Universal\CallUpdateEvent;

class CallUpdateListener
{
    public function handle(CallUpdateEvent $event) {
        CallLog::create(['call_id' => $event->call->id, 'message' => 'Call information was updated.']);
    }
}