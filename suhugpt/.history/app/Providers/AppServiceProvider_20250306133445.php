<?php

namespace App\Providers;
use App\Models\Sensor;
use App\Observers\SensorObserver;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Log::info("SensorObserver telah didaftarkan!"); // Tambahkan log untuk debugging

        Sensor::observe(SensorObserver::class);

    }
}
