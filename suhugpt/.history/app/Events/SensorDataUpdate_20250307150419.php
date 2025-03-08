<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Sensor;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; // Jika butuh real-time


class SensorDataUpdate
{
    use Dispatchable, SerializesModels;

    public $sensorData;

    public function __construct(Sensor $sensorData)
    {
        $this->sensorData = $sensorData;
    }
}
