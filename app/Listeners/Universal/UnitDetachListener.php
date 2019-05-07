<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Listeners\Universal;


use App\Events\Police\StatusChangeEvent;
use App\Events\Universal\CallAssignEvent;
use App\Events\Universal\UnitDetachEvent;

class UnitDetachListener
{
    public function handle(UnitDetachEvent $event) {
        $unit = $event->unit;
        $unit->call_id = null;
        $unit->save();
        event(new StatusChangeEvent($unit, 'Available'));
    }
}