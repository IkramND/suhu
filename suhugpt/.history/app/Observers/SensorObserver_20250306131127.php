<?php

namespace App\Observers;

use App\Events\SensorDataUpdate;
use App\Models\Sensor;

class SensorObserver
{
    /**
     * Method ini akan otomatis dipanggil saat ada data baru masuk.
     */
    public function created(Sensor $sensor)
    {
        \Log::info("SensorObserver dipanggil untuk id_mesin: {$sensor->id_mesin}");

        // Kirim event ketika data baru dibuat
        event(new SensorDataUpdate($sensor));
    }
}
