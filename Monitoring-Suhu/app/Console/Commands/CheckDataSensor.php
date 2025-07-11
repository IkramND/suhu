<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CheckDataSensor extends Command
{
    protected $signature = 'sensor:cek';
    protected $description = 'Check sensor data and take action if there is a problem.';

    public function handle()
    {
        Log::info("Job Start!");
        $latest_id = 0;
        $index = 0;

        while (true) {

            Log::info("---------------------------------------");
            Log::info("          JOB SELECT DATA              ");
            Log::info("---------------------------------------");

            $sql = 'SELECT a.id as sensor_id, a.*, b.*, c.*
                    FROM data_sensor a
                    JOIN configuration b ON a.id_mesin = b.id_mesin
                    JOIN alat c on a.id_mesin = c.id_mesin
                    ORDER BY a.id DESC
                    LIMIT 1';

            $data = DB::select($sql);





            $data = $data[0];

            Log::info("Latest Id : " . $latest_id);
            Log::info("Data Id : " . $data->sensor_id);

            if ($index == 0) {
                $latest_id = $data->sensor_id;
            }

            if ($latest_id == $data->sensor_id && $index > 0) {
                Log::info("<<<>>> Wait <<<>>>");
                Log::info("Data Still Same!!...");
                sleep(3);
                continue;
            }

            if ($latest_id != $data->sensor_id || $index == 0) {

                $latest_id = $data->sensor_id;
                $index++;


                $message = "";
                $conditions = [
                    $data->suhu > $data->batas_atas_suhu,
                    $data->suhu < $data->batas_bawah_suhu,
                    $data->kelembaban > $data->batas_atas_kelembaban,
                    $data->kelembaban < $data->batas_bawah_kelembaban
                ];

                if (in_array(true, $conditions, true)) {
                    $message = "⚠️ *Warning! Temperature and Humidity Sensor Data Not Within Safe Limits!*\n";
                    $message .= "Machine ID: *{$data->id_mesin}*\n";
                    $message .= "Location : *{$data->lokasi}*\n";
                    $message .= "Temperature : *{$data->suhu}°C* (Limit: {$data->batas_bawah_suhu}°C - {$data->batas_atas_suhu}°C)\n";
                    $message .= "Humidity : *{$data->kelembaban}%* (Limit: {$data->batas_bawah_kelembaban}% - {$data->batas_atas_kelembaban}%)\n";
                }
                Log::info('Telegram Bot Token: ' . config('services.telegram.bot_token'));
                Log::info('Telegram Chat ID: ' . config('services.telegram.chat_id'));

                Log::info("---------------------------------------");
                Log::info("          SEND TO TELEGRAM             ");
                Log::info("---------------------------------------");


                if (!empty($message)) {
                    $botToken = config('services.telegram.bot_token');
                    $chatId = config('services.telegram.chat_id');



                    $response = Http::timeout(5)->post("https://api.telegram.org/bot{$botToken}/sendMessage", [

                        'chat_id' => $chatId,
                        'text' => $message,
                        'parse_mode' => 'Markdown'
                    ]);

                    Log::info("🔍 Bot Token: " . $botToken);
                    Log::info("🔍 Chat ID: " . $chatId);

                    // Log respons dari Telegram
                    Log::info("📩 Telegram Response: " . $response->body());

                    // Cek jika request gagal
                    if (!$response->successful()) {
                        Log::error("❌ Gagal mengirim ke Telegram: " . $response->body());
                    }

                    // Ambil daftar email dari database
                    $notificationEmails = Notification::pluck('email')->filter()->toArray();

                    // Kirim email jika daftar email tidak kosong
                    if (!empty($notificationEmails)) {
                        Log::info("📧 Sending email to: " . implode(", ", $notificationEmails));


                        Mail::raw($message, function ($mail) use ($notificationEmails,$data) {
                            $mail->to($notificationEmails)->subject("Your machine has a problem : {$data->id_mesin}");
                        });
                    }
                }
            }

            sleep(300); // Tunggu sebelum iterasi berikutnya
        }
    }
}
