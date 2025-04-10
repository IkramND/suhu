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
use App\Http\Controllers\ReportController;
use App\Models\Notification;

//Email Notification
Route::get('/admin/add-configuration', [NotificationController::class, 'create']) ->name('admin.create.notification');
Route::post('/admin/add-emailconfiguration', [NotificationController::class, 'AddEmail'])->name('admin.add.notification');
Route::get('/admin/Emailconfigurartion-list', [NotificationController::class, 'index'])->name('admin.emailnotification.list');
Route::delete('/admin/EmailConfiguration-destroy/{id}', [NotificationController::class, 'destroy'])->name('admin.notification.destroy');



//Report
Route::post('/report-result-history', [ReportController::class, 'ReportResult'])->name('report.result');
Route::get('/report-history-export',[ReportController::class, 'indexExport'])->name('report.export');
Route::post('/report-history-export', [ReportController::class, 'processStep1'])->name('report.processStep1'); // Proses Step 1
Route::get('/report-history-export-step2', [ReportController::class, 'indexExport2'])->name('report.exportStep2'); // Step 2
Route::post('/report-history-export-step2', [ReportController::class, 'processStep2'])->name('report.processStep2'); // Proses Step 2
Route::get('/report-history-form',[ReportController::class,'index'])->name('index.report');



Route::get('/admin/report', [PDFController::class, 'index']) -> name('admin.report');

Route::post('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');

// Card alat
Route::get('/admin/create', [CardController::class, 'create'])->name('admin.create');
Route::post('/admin/store', [CardController::class, 'store'])->name('admin.store');
Route::delete('/alat/{id}', [CardController::class, 'destroy'])->name('alats.destroy');
Route::get('/alats/{id}/edit', [CardController::class, 'edit'])->name('alats.edit');
Route::get('/admin/machine-list', [CardController::class, 'indexlist'])->name('alat.list');
Route::get('/get-alats', [CardController::class, 'getAlats']);




Route::put('/alats/{id}', [CardController::class, 'update'])->name('alats.update');

Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::get('/sensor/fetch-history', [HistoryController::class, 'fetchHistory']);
Route::get('/admin/editalat/{id}', [Cardcontroller::class, 'Editalat'])->name('Editalat');


// Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);


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
    Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);




    Route::get('/history/ROB1', function () {
        return view('History.ROB1');
    });



    Route::get('/data-suhu', [SensorController::class, 'index']);
    Route::get('/history/ROB1', [SensorController::class, 'fetchDataHistory_ROB1'])->name('ROB1');




    Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataHistory'])->where('id_mesin', '[A-Za-z0-9]+')->name('fetchDataHistory');

    Route::get('/sensor/fetch-data-lokasi', [SensorController::class, 'fetchDataLokasi']);



    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');















    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


});



