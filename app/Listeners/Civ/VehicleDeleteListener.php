<?php


namespace App\Listeners\Civ;


use App\Events\Civ\CharacterDeleteEvent;
use App\Events\Civ\VehicleDeleteEvent;

class VehicleDeleteListener
{

    public function handle(VehicleDeleteEvent $event)
    {
        $event->vehicle->delete();
    }

}