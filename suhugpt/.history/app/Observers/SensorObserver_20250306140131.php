<?php

namespace App\Observers;

use App\Events\SensorDataUpdate;
use App\Models\Sensor;
use Illuminate\Support\Facades\Log;


class SensorObserver
{
    /**
     * Method ini akan otomatis dipanggil saat ada data baru masuk.
     */
    public function created(Sensor $sensor)
    {
        Log::info("SensorObserver dipanggil untuk id_mesin: {$sensor->id_mesin}, suhu: {$sensor->suhu}, kelembaban: {$sensor->kelembaban}");

        // Kirim event ketika data baru dibuat
        event(new SensorDataUpdate($sensor));
    }
}
