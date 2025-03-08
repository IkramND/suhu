<?php

namespace App\Console\Scheduling

protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
{
    $schedule->command('check:sensor')->everyMinute()->withoutOverlapping();
}
