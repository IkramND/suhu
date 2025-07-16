<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\ReportResult;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Alat;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Facades\Log;


use Mockery\Matcher\Not;

class ReportController extends Controller
{


    public function index()
    {
        $alats = Alat::all();
        return view('Report.ReportForm', compact('alats'));
    }


    public function indexExport()
    {
        $notifications = Notification::all();
        return view('Report.ReportFInalExport', compact('notifications'), ['step' => 1]);
    }

    public function processStep1(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:notification,email',
        ]);

        Session::put('user_email', $request->email);

        return redirect()->route('report.exportStep2');
    }



    public function indexExport2()
    {
        $alats = Alat::all();
        return view('Report.ReportFInalExport', ['step' => 2], compact('alats'));
    }

    public function processStep2(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'file' => 'required',
            'archive' => 'required'
        ]);

        $email = Session::get('user_email');

        $alat = Alat::where('id_mesin', $request->id_mesin)->first();
        if (!$alat) {
            return back()->with('error', 'Not found');
        }

        $sensorData = Sensor::select(
            DB::raw('DATE(waktu) as tanggal'),
            DB::raw('MIN(suhu) as lowest_temperature'),
            DB::raw('MAX(suhu) as highest_temperature'),
            DB::raw('MIN(kelembaban) as lowest_humidity'),
            DB::raw('MAX(kelembaban) as highest_humidity'),
            DB::raw('ROUND(AVG(suhu),2) as average_temperature'),
            DB::raw('ROUND(AVG(kelembaban),2) as average_humidity'),
        )
            ->where('id_mesin', $request->id_mesin)
            ->whereBetween('waktu', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
            ->groupBy(DB::raw('DATE(waktu)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        if (!$email) {
            return redirect()->route('report.export')->withErrors(['email' => 'please enter your email first']);
        }

        $data = [
            'email' => $request->email,
            'id_mesin' => $request->id_mesin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),
            'sensor_data' => $sensorData
        ];

        if ($request->file == 'PDF') {
            $pdf = PDF::Loadview('admin.Reportresult', $data);
            Mail::send('emails.report', ['data' => $data], function ($message) use ($email, $pdf) {
                $message->to($email)->subject('Report Machine PDF');
                $message->attachData($pdf->output(), 'Machine_Report.pdf');
            });

            foreach ($sensorData as $sensor) {
                ReportResult::create([
                    'id_mesin' => $request->id_mesin,
                    'average_temperature' => $sensor->average_temperature,
                    'average_humidity' => $sensor->average_humidity,
                    'lowest_temperature' => $sensor->lowest_temperature,
                    'highest_temperature' => $sensor->highest_temperature,
                    'lowest_humidity' => $sensor->lowest_humidity,
                    'highest_humidity' => $sensor->highest_humidity,
                    'waktu' => $sensor->tanggal,
                    'created_at' => Carbon::now()->setTimezone('Asia/Jakarta'),
                    'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
                ]);
            }

            if ($request->archive == 'YES') {
                // Delete processed data
                Sensor::where('id_mesin', $request->id_mesin)
                    ->whereBetween('waktu', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
                    ->delete();
            }

            Session::forget('user_email');
            return $pdf->stream('pdf_file.pdf');
        }

        if ($request->file == 'CSV') {
            $filename = 'Report_' . $request->start_date . '__' . $request->end_date  . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $columns = [
                'Date',
                'Lowest Temperature',
                'Highest Temperature',
                'Average Temperature',
                'Lowest Humidity',
                'Highest Humidity',
                'Average Humidity'
            ];

            $tempCsv = fopen('php://temp', 'r+');
            fputcsv($tempCsv, $columns, ';');

            foreach ($sensorData as $row) {
                fputcsv($tempCsv, [
                    $row->tanggal,
                    number_format($row->lowest_temperature, 2),
                    number_format($row->highest_temperature, 2),
                    number_format($row->average_temperature, 2),
                    number_format($row->lowest_humidity, 2),
                    number_format($row->highest_humidity, 2),
                    number_format($row->average_humidity, 2)
                ], ';');
            }

            rewind($tempCsv);
            $csvContent = stream_get_contents($tempCsv);
            fclose($tempCsv);

            Mail::send('emails.report', ['data' => $data], function ($message) use ($email, $csvContent, $filename) {
                $message->to($email)->subject('Report Machine CSV');
                $message->attachData($csvContent, $filename, [
                    'mime' => 'text/csv',
                ]);
            });

            $callback = function () use ($sensorData, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns, ';');

                foreach ($sensorData as $row) {
                    fputcsv($file, [
                        $row->tanggal,
                        number_format($row->lowest_temperature, 2),
                        number_format($row->highest_temperature, 2),
                        number_format($row->lowest_humidity, 2),
                        number_format($row->highest_humidity, 2),
                        number_format($row->average_temperature, 2),
                        number_format($row->average_humidity, 2)
                    ], ';');
                }

                fclose($file);
            };

            if ($request->archive == 'YES') {
                Sensor::where('id_mesin', $request->id_mesin)
                    ->whereBetween('waktu', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
                    ->delete();
            }
            Session::forget('user_email');

            return response()->stream($callback, 200, $headers);
        }
    }



    public function ReportResult(Request $request)
    {
        $request->merge([
            'month' => (int) ltrim($request->month, '0'),
        ]);

        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
            'file' => 'required'
        ]);

        $alat = Alat::where('id_mesin', $request->id_mesin)->first();



        $month = (int)$request->month;
        $year = (int)$request->year;

        $ReportResult = ReportResult::selectRaw('DATE(waktu) as tanggal, average_temperature,average_humidity,lowest_temperature,highest_temperature,lowest_humidity,highest_humidity')
            ->where('id_mesin', $request->id_mesin)
            ->whereMonth('waktu', $month)
            ->whereYear('waktu', $year)
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($month < 10) {
            $month = 0 . $month;
        } else {
            $month;
        }

        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'month' => $month,
            'year' => $year,
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Ganti dengan zona waktu pengguna

            'sensor_data' => $ReportResult
        ];


        if ($request->file == 'PDF') {

            $pdf = PDF::Loadview('Report.ReportFinalHistory', $data);

            return $pdf->stream('pdf_file.pdf');
        }
        if ($request->file == 'CSV') {
            $filename = 'ReportArchive_' . $month . '_' . $year . '.csv';

            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\""
            ];

            $columns = [
                'Date',
                'Lowest Temperature',
                'Highest Temperature',
                'Average Temperature',
                'Lowest Humidity',
                'Highest Humidity',
                'Average Humidity',
            ];


            $callback = function () use ($ReportResult, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns, ';');

                foreach ($ReportResult as $row) {
                    fputcsv($file, [
                        $row->tanggal,
                        number_format($row->lowest_temperature, 2),
                        number_format($row->highest_temperature, 2),
                        number_format($row->average_temperature, 2),
                        number_format($row->lowest_humidity, 2),
                        number_format($row->highest_humidity, 2),
                        number_format($row->average_humidity, 2)


                    ], ';');
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
    }

    public function reportdaily()
    {
        $alats = Alat::all();
        return view('Report.ReportDaily', compact('alats'));
    }

    public function reportdailypost(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'dates' => 'required',
            'file' => 'required'
        ]);

        $alat = Alat::where('id_mesin', $request->id_mesin)->first();
        $dates = $request->dates;

        $reportdailyresult = Sensor::select(
            DB::raw('DATE(waktu) AS Tanggal'),
            DB::raw('HOUR(waktu) AS Jam'),
            DB::raw('MIN(suhu) AS lowest_temperature'),
            DB::raw('MAX(suhu) AS highest_temperature'),
            DB::raw('MIN(kelembaban) AS lowest_humidity'),
            DB::raw('MAX(kelembaban) AS highest_humidity'),
            DB::raw('AVG(suhu) AS average_temperature'),
            DB::raw('AVG(kelembaban) AS average_humidity')
        )
            ->where('id_mesin', $request->id_mesin)
            ->whereDate('waktu', $request->dates)
            ->groupBy(DB::raw('DATE(waktu)'), DB::raw('HOUR(waktu)'))
            ->orderBy('Tanggal')
            ->orderBy('Jam')
            ->get();

        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'dates' => $dates,
            'file' => $request->file,
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'), // Ganti dengan zona waktu pengguna

            'sensor_data' => $reportdailyresult
        ];


        if ($request->file == 'PDF') {
            $pdf = PDF::Loadview('admin.ReportDailyResult', $data);
            return $pdf->stream('pdf_file.pdf');
        }


        if ($request->file == 'CSV') {
            $filename = 'Report_' . $dates . '.csv';

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"$filename\"",
            ];

            $columns = [
                'Time',
                'Lowest Temperature',
                'Highest Temperature',
                'Average Temperature',
                'Lowest Humidity',
                'Highest Humidity',
                'Average Humidity'
            ];

            $callback = function () use ($reportdailyresult, $columns, $request) {
                $file = fopen('php://output', 'w');

                fputcsv($file, $columns, ';');

                foreach ($reportdailyresult as $row) {
                    fputcsv($file, [
                        $row->Jam . ":00",
                        number_format($row->lowest_temperature, 2),
                        number_format($row->highest_temperature, 2),
                        number_format($row->average_temperature, 2),
                        number_format($row->lowest_humidity, 2),
                        number_format($row->highest_humidity, 2),
                        number_format($row->average_humidity, 2)

                    ], ';');
                }


                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
    }

    public function reportanalyze()
    {
        $alats = Alat::all();
        return view('Report.ReportAnalyze', compact('alats'));
    }

    public function reportanalyzepost(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'file' => 'required',
        ]);

        $sensorData = Sensor::select(
            DB::raw('DATE(waktu) as tanggal'),
            DB::raw('MIN(suhu) as lowest_temperature'),
            DB::raw('MAX(suhu) as highest_temperature'),
            DB::raw('MIN(kelembaban) as lowest_humidity'),
            DB::raw('MAX(kelembaban) as highest_humidity'),
            DB::raw('ROUND(AVG(suhu),2) as average_temperature'),
            DB::raw('ROUND(AVG(kelembaban),2) as average_humidity'),
        )
            ->where('id_mesin', $request->id_mesin)
            ->whereBetween('waktu', [$request->start_date . ' 00:00:00', $request->end_date . ' 23:59:59'])
            ->groupBy(DB::raw('DATE(waktu)'))
            ->orderBy('tanggal', 'asc')
            ->get();

        $prompt = "Berikut adalah laporan harian suhu dan kelembaban ruang server. Setiap data mencakup suhu terendah, suhu tertinggi, rata-rata suhu, serta kelembaban terendah, kelembaban tertinggi, dan rata-rata kelembaban per tanggal pada ID mesin {$request->id_mesin}.

                    Tolong lakukan analisa lengkap dan detail serta saran untuk report suhu ruang server tersebut.

                    Jawaban harus:
                    - Ditulis dalam bahasa formal laporan teknis
                    - Dalam bentuk teks biasa saja
                    - Tanpa menyisipkan grafik, gambar, markdown, simbol markdown, atau format seperti bold, gambar, atau tautan apapun
                    - Cocok untuk langsung dimasukkan ke dokumen Word

                    Berikut datanya:";

        $stringdata = '';
        foreach ($sensorData as $row) {
            $stringdata .= "Tanggal: {$row->tanggal}, Suhu Terendah: {$row->lowest_temperature}°C, Suhu Tertinggi: {$row->highest_temperature},Rata-Rata suhu: {$row->average_temperature},Kelembaban Terendah: {$row->lowest_humidity},Kelembaban Tertinggi: {$row->highest_humidity} Rata-Rata Kelembaban: {$row->average_humidity}%\n";
        }

        $combinedPrompt = $prompt . "\n\n" . $stringdata;

        // Log::info('API Key Used for AI', ['key' => env('GROQ_API_KEY')]);


        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.groq.key'),
        ])->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => $combinedPrompt
                        ]
                    ]
                ]
            ]
        ]);

        Log::info('AI Prompt: ', ['prompt' => $combinedPrompt]);

        if (!$response->successful()) {
            Log::error('AI API Failed', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return response()->json([
                'error' => 'AI API failed',
                'status' => $response->status(),
                'response' => $response->json()
            ]);
        }

        $result = $response->json();
        $text = $result['choices'][0]['message']['content'] ?? null;

        if (!$text || trim($text) === '') {
            return response()->json([
                'error' => 'AI returned empty response',
                'raw_response' => $result
            ]);
        }


        $filename = "Temperature_Report_Analysis_{$request->start_date}_To_{$request->end_date}.docx";
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();
        $lines = explode("\n", $text);
        $section->addTitle('Hasil Analisis', 1);

        foreach ($lines as $line) {
            $trimmed = trim($line);
            $textRun = $section->addTextRun();

            if (str_starts_with($trimmed, '-')) {
                $this->addMarkdownFormattedText($textRun, ltrim($trimmed, '- '));
            } else {
                $this->addMarkdownFormattedText($textRun, $trimmed);
            }
        }

        $wordPath = storage_path("app/{$filename}");
        $phpWord->save($wordPath, 'Word2007');

        return response()->download($wordPath)->deleteFileAfterSend(true);
    }


    private function addMarkdownFormattedText($textRun, $text)
    {
        // Pisahkan berdasarkan **bold**
        $segments = preg_split('/(\*\*.*?\*\*)/', $text, -1, PREG_SPLIT_DELIM_CAPTURE);

        foreach ($segments as $segment) {
            if (preg_match('/\*\*(.*?)\*\*/', $segment, $match)) {
                $textRun->addText($match[1], ['bold' => true]);
            } else {
                $textRun->addText($segment);
            }
        }
    }
}
