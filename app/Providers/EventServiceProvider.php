<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Police\CallsignChangeEvent' => [
            'App\Listeners\Police\CallsignChangeListener',
        ],
        'App\Events\Police\StatusChangeEvent' => [
            'App\Listeners\Police\StatusChangeListener',
        ],
        'App\Events\Universal\CallAssignEvent' => [
            'App\Listeners\Universal\CallAssignListener'
        ],
        'App\Events\Universal\UnitDetachEvent' => [
            'App\Listeners\Universal\UnitDetachListener'
        ],
        'App\Events\Universal\CallArchiveEvent' => [
            'App\Listeners\Universal\CallArchiveListener'
        ],
        'App\Events\Universal\CallUpdateEvent' => [
            'App\Listeners\Universal\CallUpdateListener'
        ],
        'App\Events\Civ\CharacterDeleteEvent' => [
            'App\Listeners\Civ\CharacterDeleteListener'
        ]
    ];
}
