<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AuthController;

// Route yang bisa diakses tanpa login
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

Route::post('/sendOtp', function (Request $request) {
    // Validasi email
    $request->validate(['email' => 'required|email']);

    // Generate OTP (6 digit angka acak)
    $otp = rand(100000, 999999);
    $email = $request->email;

    // Logging untuk debug
    Log::info("Sending OTP: $otp to $email");

    // Kirim email OTP
    Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
        $message->to($email)->subject("Your OTP Code");
    });

    // Return response JSON
    return response()->json([
        'success' => true,
        'message' => 'OTP sent successfully',
        'email' => $email
    ]);
})->name('sendOtp');


Route::post('/changePass', [AuthController::class, 'changePass']);

Route::post('/sendEmail', [AuthController::class, 'sendEmail'])->name('sendEmail');

Route::post('/login', [AuthController::class, 'login']) ->name('login');

Route::get('/changePassPage', function () {
    return view('auth.changePass');
});


// Middleware untuk memastikan user login sebelum mengakses routes berikutnya
Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('utama');
    })->name('utama');

    Route::get('/history/ROB1', function () {
        return view('History.ROB1');
    });



    Route::get('/data-suhu', [SensorController::class, 'index']);
    Route::get('/history/ROB1', [SensorController::class, 'fetchDataHistory_ROB1'])->name('ROB1');
    Route::get('/history/ROB2', [SensorController::class, 'fetchDataHistory_ROB2']);
    Route::get('/history/ROB3', [SensorController::class, 'fetchDataHistory_ROB3']);

    Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);
    Route::get('/sensor/fetch-data-lokasi', [SensorController::class, 'fetchDataLokasi']);
    Route::get('/sensor/fetch-data-rob1', [SensorController::class,'fetchDataHistoryROB1']);
    Route::get('/sensor/fetch-data-rob2', [SensorController::class,'fetchDataHistoryROB2']);

    // Route::get('/dashboard', function () {
    //     return view('utama');
    // })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});



