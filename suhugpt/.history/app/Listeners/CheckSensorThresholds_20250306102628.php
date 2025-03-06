<?php

namespace App\Listeners;

use App\Events\SensorDataUpdate;
use App\Models\Configuration;
use App\Service\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckSensorThreesholds
{
    /**
     * Create the event listener.
     */

     protected $telegram;





    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Handle the event.
     */
    public function handle(SensorDataUpdate $event): void
    {
        $data = $event->sensorData;

        $config = Configuration::where('id_mesin' ,$data->id_mesin) -> first();

        if(!$config){
            return;
        }

        $alertMessage = "";

        //check limit Temperature
        if($data->suhu > $config->batas_atas_suhu){
            $alertMessage .="⚠️ Temperature in machine {$data->id_mesin} is to High!!! Current Temperature is {$data->suhu}°C.";
        }elseif($data->suhu < $config->batas_bawah_suhu){
            $alertMessage .="⚠️ Temperature in machine {$data->id_mesin} is to Low!!! Current Temperature is {$data->suhu}°C.";
        }


        //check limit Humidity
        if($data->suhu > $config->batas_atas_kelembaban){
            $alertMessage .="⚠️ Humidity in machine {$data->id_mesin} is to High!!! Current Humidity is {$data->kelembaban}%.";
        }elseif($data->suhu < $config->batas_bawah_kelembaban){
            $alertMessage .="⚠️ Humidity in machine {$data->id_mesin} is to Low!!! Current Humidity is{$data->kelembaban}%.";

        }

        if(!empty($alertMessage)){
            $this->telegram->sendMessage($alertMessage);
        }
    }
}
