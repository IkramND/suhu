<?php

namespace App\Console\Commands;

use App\Models\Sensor;
use Illuminate\Console\Command;

class CheckSensorData extends Command
{

    protected $signature = 'check:sensor';
    protected $description = 'check sensor data';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'app:check-sensor-data';

    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $latesdata = Sensor::latest('id')->first();
        // $latestdata = Sensor::orderBy('id', 'desc')->first();
    }
}
