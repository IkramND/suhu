<?php

namespace App\Listeners;

use App\Events\SensorDataUpdate;
use App\Models\Configuration;
use App\Service\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CheckSensorThreesholds
{
    /**
     * Create the event listener.
     */

     protected $telegram;





    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram
    }

    /**
     * Handle the event.
     */
    public function handle(SensorDataUpdate $event): void
    {
        //
    }
}
