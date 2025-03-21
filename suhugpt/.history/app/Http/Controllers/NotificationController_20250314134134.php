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
        $notifications = Notification::all();
        return view('admin.ListNotification',compact('notifications'));
    }

    public function create(){
        return view('admin.AddNotification');
    }



    public function AddEmail(Request $request){

        $request->validate([
            'email' => 'required|email'
        ]);

        if (Notification::where('email', $request->email)->exists()) {
            return redirect()->back()->withErrors(['email' => 'Email sudah terdaftar, gunakan email lain.']);
        }


        Notification::create([
            'email' => $request->email
        ]);

        return redirect()->route('admin.emailnotification.list')->with('success','Email is added');

    }

    public function destroy($id){
        $notification = Notification::findOrfail($id);
        $notification->delete();

        return redirect()->route('admin.emailnotification.list')->with('success','Email has beed destroy ');
    }

    public function SendEmail(Request $request){

        $request->validate([
            'email' => 'required'
        ]);

        $notification = Notification::where('email', $request->email)->get();

        if($notification){

        }


    }





}

