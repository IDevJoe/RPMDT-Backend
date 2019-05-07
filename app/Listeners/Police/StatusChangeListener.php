<?php

namespace App\Listeners\Police;

use App\Events\ExampleEvent;
use App\Events\Police\CallsignChangeEvent;
use App\Events\Police\StatusChangeEvent;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatusChangeListener
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
    public function handle(StatusChangeEvent $event)
    {
        $u = $event->user;
        $u->status = $event->newStatus;
        $u->save();
    }
}
