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
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Models\Sensor;
use App\Events\SensorDataUpdate;

Route::get('/test-alert', function () {
    $sensor = Sensor::latest()->first();
    if ($sensor) {
        event(new SensorDataUpdate($sensor));
        return "Event telah dikirim!";
    }
    return "Tidak ada data sensor.";
});


// Route::get('/check-alert', [NotificationController::class, 'checkAndSendAlert']);



Route::get('/admin/report', [PDFController::class, 'index']) -> name('admin.report');

Route::post('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');

// Card alat
Route::get('/admin/create', [CardController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [CardController::class, 'store'])->name('admin.store');
Route::delete('/alat/{id}', [CardController::class, 'destroy'])->name('alats.destroy');
Route::get('/alats/{id}/edit', [CardController::class, 'edit'])->name('alats.edit');
Route::get('/admin/machine-list', [CardController::class, 'indexlist'])->name('alat.list');



Route::put('/alats/{id}', [CardController::class, 'update'])->name('alats.update');

Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::get('/sensor/fetch-history', [HistoryController::class, 'fetchHistory']);
Route::get('/admin/editalat/', [Cardcontroller::class, 'editalat'])->name('Editalat');


Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);


Route::get('/Historys/{id}', [SensorController::class, ''])->name('Historys');

Route::get('/', [CardController::class, 'dashboard'])->name('dashboard');



Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/add-configuration',[SettingController::class,'configuration'])->name('add.configuration');
Route::get('/admin/configuration', [SettingController::class,'listconfiguration'])->name('configuration.list');
Route::get('/configuration/{id}/edit', [SettingController::class, 'edit'])->name('configuration.edit');
Route::put('/configuration/{id}', [SettingController::class, 'update'])->name('configuration.update');
Route::delete('/configuration/{id}', [SettingController::class, 'destroy'])->name('configuration.destroy');
Route::get('/setting', [SettingController::class, 'settings'])->name('settings');
Route::get('/admin/configuration-list', [SettingController::class, 'index'])->name('index.configuration');



// Route::get('/admin')

Route::get('/history-page', [SensorController::class, 'SensorPage'])->name('History.page');
Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataByIdMesin']);




Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
// Route::post('/forgot-password', [AuthController::class, 'processForgotPassword']);
Route::post('/validate-user', [AuthController::class, 'validateUser'])->name('validate.user');
Route::post('/reset-password-func', [AuthController::class, 'resetPassword'])->name('reset.password.func');

Route::get('/reset-password', [AuthController::class, 'showForgotPasswordForm2'])->name('reset.password');




Route::post('/login', [AuthController::class, 'login']) ->name('login');

Route::get('/changePassPage', function () {
    return view('auth.changePassword');
});


// Middleware untuk memastikan user login sebelum mengakses routes berikutnya
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [CardController::class, 'index'])->name('card.index');



    Route::get('/history/ROB1', function () {
        return view('History.ROB1');
    });



    Route::get('/data-suhu', [SensorController::class, 'index']);
    Route::get('/history/ROB1', [SensorController::class, 'fetchDataHistory_ROB1'])->name('ROB1');




    Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataHistory'])->where('id_mesin', '[A-Za-z0-9]+')->name('fetchDataHistory');

    Route::get('/sensor/fetch-data-lokasi', [SensorController::class, 'fetchDataLokasi']);



    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');














    // Route::get('/chose', [SensorController::class, 'chose'])->name('chose');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});



