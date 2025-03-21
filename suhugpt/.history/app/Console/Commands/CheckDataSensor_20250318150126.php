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
    protected $description = 'Cek data sensor dan lakukan aksi jika ada masalah';

    public function handle()
    {
        Log::info("Job Start!");
        $latest_id = 0;
        $index = 0;

        while (true) {

            Log::info("---------------------------------------");
            Log::info("          JOB SELECT DATA              ");
            Log::info("---------------------------------------");

            $sql = 'SELECT a.id as sensor_id, a.*, b.*
                    FROM data_sensor a
                    JOIN configuration b ON a.id_mesin = b.id_mesin
                    ORDER BY a.id DESC
                    LIMIT 1';

            $data = DB::select($sql);

            // // Cek apakah ada data
            // if (empty($data)) {
            //     Log::warning("⚠️ Tidak ada data sensor terbaru, menunggu 3 detik...");
            //     sleep(3);
            //     continue;
            // }

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
                continue; // Lanjutkan loop tanpa mematikan daemon
            }

            if ($latest_id != $data->sensor_id || $index == 0) {

                $latest_id = $data->sensor_id;
                $index++;

                // Validasi sensor
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
                    $message .= "Temperature : *{$data->suhu}°C* (Batas: {$data->batas_bawah_suhu}°C - {$data->batas_atas_suhu}°C)\n";
                    $message .= "Humidity : *{$data->kelembaban}%* (Batas: {$data->batas_bawah_kelembaban}% - {$data->batas_atas_kelembaban}%)\n";
                }

                Log::info("---------------------------------------");
                Log::info("          SEND TO TELEGRAM             ");
                Log::info("---------------------------------------");

                // Kirim alert ke Telegram jika ada masalah
                if (!empty($message)) {
                    $botToken = config('services.telegram.bot_token');
                    $chatId = config('services.telegram.chat_id');


                    // Kirim pesan ke Telegram
                    $response = Http::timeout(5)->post("https://api.telegram.org/bot{botToken}/sendMessage", [
                        // 'chat_id' => env('TELEGRAM_CHAT_ID'),
                        'chat_id' => $chatId,
                        'text' => $message,
                        'parse_mode' => 'Markdown'
                    ]);

                    Log::info("🔍 Bot Token: " . env('TELEGRAM_BOT_TOKEN'));
                    Log::info("🔍 Chat ID: " . env('TELEGRAM_CHAT_ID'));

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

            sleep(3); // Tunggu sebelum iterasi berikutnya
        }
    }
}

Log::info("✅ Job Finished.");
