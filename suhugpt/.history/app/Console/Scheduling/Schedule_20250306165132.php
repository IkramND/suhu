<?php

namespace

protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule)
{
    $schedule->command('check:sensor')->everyMinute()->withoutOverlapping();
}
