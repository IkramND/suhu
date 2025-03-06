<?php

namespace App\Observers;

use App\Models\Sensor;

class SensorObserver
{
    /**
     * Handle the Sensor "created" event.
     */
    public function created(Sensor $sensor): void
    {
        //
    }

    /**
     * Handle the Sensor "updated" event.
     */
    public function updated(Sensor $sensor): void
    {
        //
    }

    /**
     * Handle the Sensor "deleted" event.
     */
    public function deleted(Sensor $sensor): void
    {
        //
    }

    /**
     * Handle the Sensor "restored" event.
     */
    public function restored(Sensor $sensor): void
    {
        //
    }

    /**
     * Handle the Sensor "force deleted" event.
     */
    public function forceDeleted(Sensor $sensor): void
    {
        //
    }
}
