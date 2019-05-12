<?php
/**
 *    (C) 2019 Joe Longendyke
 *
 */

namespace App\Events\Civ;


use App\Character;
use App\Events\Event;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class CharacterUpdateEvent extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $character;

    public function __construct(Character $c)
    {
        $this->character = $c;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return ['private-user.' . $this->character->user->id];
    }

    public function broadcastAs() {
        return 'character.update';
    }
}