<?php

namespace App\Listeners;

use App\Events\SensorDataUpdate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckSensorThreesholds
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SensorDataUpdate $event): void
    {
        //
    }
}
