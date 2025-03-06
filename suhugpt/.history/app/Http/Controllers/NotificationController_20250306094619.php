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


        if($data->suhu > $data)
    }
}
