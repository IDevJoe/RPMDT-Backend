<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Listeners\Universal;


use App\CallLog;
use App\Events\Universal\CallArchiveEvent;
use App\Events\Universal\UnitDetachEvent;

class CallArchiveListener
{
    public function handle(CallArchiveEvent $event) {
        foreach($event->call->units as $unit) {
            event(new UnitDetachEvent($unit));
        }
        CallLog::create(['call_id' => $event->call->id, 'message' => 'Call was archived.', 'type' => CallLog::TYPE_CALL_ARCHIVE]);
        $event->call->delete();
    }
}