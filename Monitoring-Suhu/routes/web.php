<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\CheckAdminRole;
use App\Models\Calibration;
use Sabberworm\CSS\Settings;

Route::get('/sensor/fetch-data', [SensorController::class, 'fetchData']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registers']);
Route::post('/register-otp', [AuthController::class, 'otpvalidation'])->name('register.validation');
Route::get('/register-acess', [AuthController::class, 'acess'])->name('acess');
Route::post('/register-acess-submit', [AuthController::class, 'acesssubmit'])->name('acess.submit');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot.password');
Route::get('/forgot-password-2', [AuthController::class, 'showForgotPasswordForm2'])->name('forgot.password2');
Route::get('/forgot-password-3', [AuthController::class, 'showForgotPasswordForm3'])->name('forgot.password3');
Route::post('/validate-user', [AuthController::class, 'validateUser'])->name('validate.user');
Route::post('/validate-user2', [AuthController::class, 'validateUser2'])->name('validate.user2');
Route::post('/validate-user3', [AuthController::class, 'validateUser3'])->name('validate.user3');
Route::post('/reset-password-func', [AuthController::class, 'resetPassword'])->name('reset.password.func');




Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/changePassPage', function () {
    return view('auth.changePassword');
});

Route::middleware([CheckAdminRole::class])->group(function () {
    Route::get('/admin', [CardController::class, 'index'])->name('card.index');

    //Email Notification
    Route::get('/admin/add-configuration', [NotificationController::class, 'create'])->name('admin.create.notification');
    Route::post('/admin/add-emailconfiguration', [NotificationController::class, 'AddEmail'])->name('admin.add.notification');
    Route::get('/admin/Emailconfigurartion-list', [NotificationController::class, 'index'])->name('admin.emailnotification.list');
    Route::delete('/admin/EmailConfiguration-destroy/{id}', [NotificationController::class, 'destroy'])->name('admin.notification.destroy');

    // Card alat
    Route::get('/admin/create', [CardController::class, 'create'])->name('admin.create');
    Route::post('/admin/store', [CardController::class, 'store'])->name('admin.store');
    Route::delete('/alat/{id}', [CardController::class, 'destroy'])->name('alats.destroy');
    Route::get('/alats/{id}/edit', [CardController::class, 'edit'])->name('alats.edit');
    Route::get('/admin/machine-list', [CardController::class, 'indexlist'])->name('alat.list');
    Route::put('/alats/{id}', [CardController::class, 'update'])->name('alats.update');
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::get('/sensor/fetch-history', [HistoryController::class, 'fetchHistory']);
    Route::get('/admin/editalat/{id}', [Cardcontroller::class, 'Editalat'])->name('Editalat');


    //Configuration
    Route::get('/setting', [SettingController::class, 'settings'])->name('settings');
    Route::post('/add-configuration', [SettingController::class, 'configuration'])->name('add.configuration');
    Route::get('/admin/configuration', [SettingController::class, 'listconfiguration'])->name('configuration.list');
    Route::get('/configuration/{id}/edit', [SettingController::class, 'edit'])->name('configuration.edit');
    Route::put('/configuration/{id}', [SettingController::class, 'update'])->name('configuration.update');
    Route::delete('/configuration/{id}', [SettingController::class, 'destroy'])->name('configuration.destroy');
    Route::get('/admin/configuration-list', [SettingController::class, 'index'])->name('index.configuration');

    //Report
    Route::post('/report-result-history', [ReportController::class, 'ReportResult'])->name('report.result');
    Route::get('/report-history-export', [ReportController::class, 'indexExport'])->name('report.export');
    Route::post('/report-history-export', [ReportController::class, 'processStep1'])->name('report.processStep1'); // Proses Step 1
    Route::get('/report-history-export-step2', [ReportController::class, 'indexExport2'])->name('report.exportStep2'); // Step 2
    Route::post('/report-history-export-step2', [ReportController::class, 'processStep2'])->name('report.processStep2'); // Proses Step 2
    Route::get('/report-history-form', [ReportController::class, 'index'])->name('index.report');
    Route::get('/admin/report', [PDFController::class, 'index'])->name('admin.report');
    Route::post('/generate-pdf', [PDFController::class, 'generatePDF'])->name('generate.pdf');
    Route::get('/report-daily', [ReportController::class, 'reportdaily'])->name('reportdaily');
    Route::post('/report-daily-post', [ReportController::class, 'reportdailypost'])->name('reportdailypost');
    Route::get('/report-analyze', [ReportController::class, 'reportanalyze'])->name('report.analyze');
    Route::post('/report-analyze', [ReportController::class, 'reportanalyzepost'])->name('report.analyze.post');

    //Operator
    Route::get('/operator-list', [OperatorController::class, 'list'])->name('operator.list');
    Route::get('/operator/{id}/edit', [OperatorController::class, 'edit'])->name('operator.edit');
    Route::put('/operator/{id}', [OperatorController::class, 'update'])->name('operator.update');
    Route::delete('/operator/{id}', [OperatorController::class, 'destroy'])->name('operator.destroy');

    //Calibration
    Route::get('/add-calibration', [SettingController::class, 'addcalibration'])->name('add.calibration');
    Route::post('/add-calibrations', [SettingController::class, 'addscalibration'])->name('adds.calibration');
    Route::get('/calibration-list', [SettingController::class, 'calibrationlist'])->name('calibration.list');
    Route::get('/calibration/{id}/edit', [SettingController::class, 'editcalibration'])->name('calibration.edit');
    Route::put('/calibration/{id}', [SettingController::class, 'updatecalibration'])->name('calibration.update');
    Route::delete('/calibration/{id}', [SettingController::class, 'deletecalibration'])->name('calibration.destroy');

    //Data Retention
    Route::get('/add-data-retention',[SettingController::class, 'adddataretention'])->name('add.dataretention');
    Route::post('/adds-data-retention', [SettingController::class, 'addsdataretention'])->name('adds.dataretention');
    Route::get('/data-retention', [SettingController::class, 'dataretention'])->name('dataretention');
    Route::get('/edit-data-retention/{id}/edit', [SettingController::class, 'editdataretention'])->name('dataretention.edit');
    Route::put('/update-data-retention/{id}', [SettingController::class, 'updatedataretention' ])->name('dataretention.update');


    Route::get('/change-password', [AuthController::class, 'showChangePasswordForm'])->name('password.change');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update');
});


Route::middleware(['auth'])->group(
    function () {

        Route::get('/', [CardController::class, 'dashboard'])->name('dashboard');

        // Route::get('/sensor/fetch-data/{id_mesin}', [SensorController::class, 'fetchDataHistory'])->where('id_mesin', '[A-Za-z0-9]+')->name('fetchDataHistory');

        Route::get('/get-alats', [CardController::class, 'getAlats']);



        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    }
);
