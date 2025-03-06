<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Configuration;
use App\Service\TelegramService;

class NotificationController extends Controller
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function checkAndSendAlert(){
        $sensorData = Sensor::orderBy('waktu','desc')->get();
    }

    foreach($sensorData as $data){

        $config = Configuration::where('id_mesin', $data->id_mesin)->first();
        $alertMessage = "";

        if(!config){
            continue;
        }

        $alertMessage = "";


        if($data->suhu > $config->batas_atas_suhu){
            $alertMessage .="⚠️ Temperature in machine {$data->id_mesin} is to High!!! Current Temperature is {$data->suhu}°C.";
        }elseif($data->suhu < $config->batas_bawah_suhu){
            $alertMessage .="⚠️ Temperature in machine {$data->id_mesin} is to Low!!! Current Temperature is {$data->suhu}°C."
        }
        }
    }
}
