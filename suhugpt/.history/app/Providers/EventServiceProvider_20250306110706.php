<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\SensorDataUpdate;
use App\Listeners\CheckSensorThresholds;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        SensorDataUpdate::class => [
            CheckSensorThresholds::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
