<?php

namespace App\Listeners\Police;

use App\Events\ExampleEvent;
use App\Events\Police\CallsignChangeEvent;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CallsignChangeListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ExampleEvent  $event
     * @return void
     */
    public function handle(CallsignChangeEvent $event)
    {
        $u = $event->user;
        $u->callsign_id = $event->newCallsign->id;
        $u->save();
    }
}
