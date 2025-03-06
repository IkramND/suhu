<?php


namespace App\Listeners;

use App\Events\SensorDataUpdate;
use App\Models\Configuration;
use App\Service\TelegramService;
use Illuminate\Queue\InteractsWithQueue;

class CheckSensorThresholds // Perbaiki nama class
{
    protected $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    public function handle(SensorDataUpdate $event): void
    {
        // \Log::info('Listener CheckSensorThresholds diproses', ['data' => $event->sensorData]);

        $data = $event->sensorData;
        $config = Configuration::where('id_mesin', $data->id_mesin)->first();

        if (!$config) {
            // \Log::warning("Konfigurasi tidak ditemukan untuk id_mesin: {$data->id_mesin}");
            return;
        }

        // \Log::info("Konfigurasi ditemukan", ['config' => $config]);

        $alertMessage = "";

        // Check suhu
        if ($data->suhu > $config->batas_atas_suhu) {
            $alertMessage .= "⚠️ Temperature in machine {$data->id_mesin} is too High!!! Current Temperature is {$data->suhu}°C.\n";
        } elseif ($data->suhu < $config->batas_bawah_suhu) {
            $alertMessage .= "⚠️ Temperature in machine {$data->id_mesin} is too Low!!! Current Temperature is {$data->suhu}°C.\n";
        }

        // Check kelembaban (Fix Kesalahan di kode Anda)
        if ($data->kelembaban > $config->batas_atas_kelembaban) {
            $alertMessage .= "⚠️ Humidity in machine {$data->id_mesin} is too High!!! Current Humidity is {$data->kelembaban}%.\n";
        } elseif ($data->kelembaban < $config->batas_bawah_kelembaban) {
            $alertMessage .= "⚠️ Humidity in machine {$data->id_mesin} is too Low!!! Current Humidity is {$data->kelembaban}%.\n";
        }

        if (!empty($alertMessage)) {
            // \Log::info("Mengirim alert ke Telegram", ['message' => $alertMessage]);
            $this->telegram->sendMessage($alertMessage);
        }
    }
}
