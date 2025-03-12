<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sensor;
use App\Models\Configuration;
use App\Models\Notification;
use App\Service\TelegramService;
use Illuminate\Support\Facades\Schema;

class NotificationController extends Controller
{
    public function index()
    {

    }

    public function create(){
        return view('admin.AddNotification');
    }



    public function AddEmail(Request $request){

        $request->validate([
            'email' => 'required|email'
        ]);


        Notification::create([
            'email' => $request->email
        ]);

        return redirect()->route('');

    }





}

