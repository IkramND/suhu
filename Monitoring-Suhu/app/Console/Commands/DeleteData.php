<?php

namespace App\Console\Commands;

use App\Models\ReportResult;
use Illuminate\Console\Command;
use App\Models\Scheduling;
use App\Models\DataRetention;
use App\Models\Sensor;
use Illuminate\Support\Facades\Log;


class DeleteData extends Command
{

    protected $signature = 'data:delete';
    protected $description = 'scheduling deletion of archive data';

    public function handle(){
        $retentionPeriodInYears = DataRetention::pluck('year')->first();

        if(is_null($retentionPeriodInYears)){
            Log::warning('No Data Retention In Table');
            Log::warning('Please Input Data Retention First');

            return;
        }

        // $this->info($schedule);

        $limits = now()->subYears($retentionPeriodInYears)->format('Y-m-d');

        // $this->info($limits);

        // $deleted = Sensor::whereDate('waktu', '<=', $limits)->delete();
        $deleted = ReportResult::whereDate('waktu', '<', $limits)->delete();


        // $count = $deleted->count();

        // $this->warn(json_encode($deleted));
        // $this->warn($deleted->toJson(JSON_PRETTY_PRINT));


        if($deleted > 0){
            // $this->info("Success Deleted $deleted Data Before $limits");
            Log::info("Success Deleted $deleted Data Before $limits");
        }else{
            // $this->info("There Is No Data Before $limits");
            Log::info("There Is No Data Before $limits");
        }


    }

}
