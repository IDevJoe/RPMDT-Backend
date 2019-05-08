<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Listeners\Universal;


use App\CallLog;
use App\Events\Police\StatusChangeEvent;
use App\Events\Universal\CallAssignEvent;

class CallAssignListener
{
    public function handle(CallAssignEvent $event) {
        $unit = $event->unit;
        $unit->call_id = $event->call->id;
        $unit->save();
        CallLog::create(['call_id' => $event->call->id, 'message' => $event->unit->currentCallsign->callsign . ' was attached']);
        event(new StatusChangeEvent($unit, 'Attached'));
    }
}