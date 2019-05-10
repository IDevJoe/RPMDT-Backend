<?php

namespace App\Listeners\Police;

use App\CallLog;
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
        if($event->user->activecall != null)
            CallLog::create(['call_id' => $event->user->activecall->id, 'message' => $event->user->currentCallsign->callsign . '\'s status was changed to ' . $event->newStatus,
                'type' => CallLog::TYPE_UNIT_STATUSCHANGE]);
    }
}
