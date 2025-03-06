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

    foreach ($sensorData as $data){

        $config = Configuration::where('id_mesin', $data->id_mesin)->first();
        $alertMessage = "";

        if(!config){
            continue;
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
        return response()->json(['message' => 'Check completed, alert sent if there is a limit condition']);
    }

