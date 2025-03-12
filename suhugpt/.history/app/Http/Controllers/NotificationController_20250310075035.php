<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Configuration;
use App\Service\TelegramService;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    public function index(Request $request)
    {

    }



    public function AddEmail(Request $request){

        $validate = $request->validate([
            'email' => 'required|email'
        ]);

        Schema::create('')

    }





}

