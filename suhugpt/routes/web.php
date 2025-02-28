<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HistoryController;
use Faker\Guesser\Name;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\LokasiAlatController;



// Card alat
Route::get('/admin/create', [CardController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [CardController::class, 'store'])->name('admin.store');
Route::get('/alat', [CardController::class, 'index'])->name('card.index');
Route::delete('/alat/{id}', [CardController::class, 'destroy'])->name('alats.destroy');
Route::get('/alat/{id}/edit', [CardController::class, 'edit'])->name('alats.edit');
Route::put('/alat/{id}', [CardController::class, 'update'])->name('alats.update');

Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::get('/sensor/fetch-history', [HistoryController::class, 'fetchHistory']);
Route::get('/admin/editalat/', [Cardcontroller::class, 'editalat'])->name('Editalat');




Route::get('/Historys/{id}', [SensorController::class, ''])->name('Historys');



// Route::get('/cards', [CardController::class, 'index'])->name('cards.index');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/history-page', [SensorController::class, 'SensorPage'])->name('History.page');
Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataByIdMesin']);


Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
// Route::post('/forgot-password', [AuthController::class, 'processForgotPassword']);
Route::post('/validate-user', [AuthController::class, 'validateUser'])->name('validate.user');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');


// Route::post('/sendOtp', function (Request $request) {
//     // Validasi email
//     $request->validate(['email' => 'required|email']);

//     // Generate OTP (6 digit angka acak)
//     $otp = rand(100000, 999999);
//     $email = $request->email;

//     // Logging untuk debug
//     Log::info("Sending OTP: $otp to $email");

//     // Kirim email OTP
//     Mail::raw("Your OTP is: $otp", function ($message) use ($email) {
//         $message->to($email)->subject("Your OTP Code");
//     });

//     // Return response JSON
//     return response()->json([
//         'success' => true,
//         'message' => 'OTP sent successfully',
//         'email' => $email
//     ]);
// })->name('sendOtp');
// Route::post('/sendOtp', [AuthController::class, 'sendotp'])->name('sendOtp');


// Route::post('/changePass', [AuthController::class, 'changePass']);

// Route::post('/sendEmail', [AuthController::class, 'sendEmail'])->name('sendEmail');

Route::post('/login', [AuthController::class, 'login']) ->name('login');

Route::get('/changePassPage', function () {
    return view('auth.changePassword');
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


    // Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDatas']);
    // Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataHistory'])->name('fetchDataHistory');
    Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataHistory'])->where('id_mesin', '[A-Za-z0-9]+')->name('fetchDataHistory');

    Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);
    Route::get('/sensor/fetch-data-lokasi', [SensorController::class, 'fetchDataLokasi']);
    Route::get('/sensor/fetch-data-rob1', [SensorController::class,'fetchDataHistoryROB1']);
    Route::get('/sensor/fetch-data-rob2', [SensorController::class,'fetchDataHistoryROB2']);


    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');

    // Route::get('/dashboard', function () {
    //     return view('utama');
    // })->name('dashboard');

    // Route::get('/sensor/fetch-all', [SensorController::class, 'fetchAllData']);







    Route::get('/sensor/ip-address', [SensorController::class, 'getIpAddress']);
    Route::get('/sensor/lokasi', [SensorController::class, 'getLokasiAlat']);

    // Route::get('/alat/{id}', [SensorController::class, 'show'])->name('alat.show');





    Route::get('/chose', [SensorController::class, 'chose'])->name('chose');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});



