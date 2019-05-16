<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Civ;


use App\Events\Event;
use App\Vehicle;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class VehicleDeleteEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $vehicle;

    public function __construct(Vehicle $vehicle)
    {
        $this->vehicle = $vehicle;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return ['private-user.' . $this->vehicle->character->user->id];
    }

    public function broadcastAs() {
        return "vehicle.delete";
    }
}