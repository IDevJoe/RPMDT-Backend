<?php


namespace App\Listeners\Civ;


use App\Events\Civ\CharacterDeleteEvent;

class CharacterDeleteListener
{

    public function handle(CharacterDeleteEvent $event)
    {
        $event->character->delete();
    }

}