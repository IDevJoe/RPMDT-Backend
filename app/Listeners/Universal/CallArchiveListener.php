<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Listeners\Universal;


use App\Events\Universal\CallArchiveEvent;
use App\Events\Universal\UnitDetachEvent;

class CallArchiveListener
{
    public function handle(CallArchiveEvent $event) {
        foreach($event->call->units as $unit) {
            event(new UnitDetachEvent($unit));
        }
        $event->call->delete();
    }
}