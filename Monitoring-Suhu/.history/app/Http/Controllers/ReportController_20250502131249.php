<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\ReportResult;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Alat;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;



class ReportController extends Controller
{


    public function index(){
        $alats = Alat::all();
        return view('Report.ReportForm',compact('alats'));
    }


    public function indexExport(){
    return view('Report.ReportFInalExport', ['step' => 1]);
    }

    public function processStep1(Request $request){
        $request->validate([
            'email' => 'required|email|exists:notification,email',
        ]);

        Session::put('user_email',$request->email);

        return redirect()->route('report.exportStep2');
    }



    public function indexExport2(){
        $alats = Alat::all();
        return view('Report.ReportFInalExport', ['step' => 2],compact('alats'));
    }

    public function processStep2(Request $request){
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $email = Session::get('user_email');

        $alat = Alat::where('id_mesin' ,$request->id_mesin)->first();
        if(!$alat){
            return back()->with('error','Not found');
        }

        $sensorData = Sensor::select(
            DB::raw('DATE(waktu) as tanggal'),
            DB::raw('COUNT(*) as jumlah_data'),
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

        if(!$email){
            return redirect()->route('report.export')->withErrors(['email' => 'please enter your email first']);
        }


        $data = [
            'email' => $request->email,
            'id_mesin' => $request->id_mesin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'ip_address' =>$alat->ip_address,
            'lokasi' => $alat->lokasi,
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),
            'sensor_data' => $sensorData
        ];


        $pdf = PDF::Loadview('admin.Reportresult', $data);
         Mail::send('emails.report',['data' => $data], function($message) use ($email,$pdf){
            $message->to($email)->subject('Report Machine');
            $message->attachData($pdf->output(),'Machine_Report.pdf');
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
                'waktu' => $sensor->tanggal, // Tanggal dari query
                'created_at' =>Carbon::now()->setTimezone('Asia/Jakarta'),
                'updated_at' => Carbon::now()->setTimezone('Asia/Jakarta')
            ]);
        }

        Sensor::where('id_mesin',$request->id_mesin)->whereBetween('waktu',[$request->start_date . ' 00:00:00',$request->end_date . ' 23:59:59'])->delete();

        Session::forget('user_email');
        return $pdf->stream('pdf_file.pdf');
    }


    public function ReportResult(Request $request)
    {
        $request->merge([
            'month' => (int) ltrim($request->month, '0'),
        ]);

        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer'
        ]);

        $alat = Alat::where('id_mesin',$request->id_mesin)->first();



        $month = (int)$request->month;
        $year = (int)$request->year;

        $ReportResult = ReportResult::selectRaw('DATE(waktu) as tanggal, average_temperature,average_humidity,lowest_temperature,highest_temperature,lowest_humidity,highest_humidity')
                ->where('id_mesin', $request->id_mesin)
                ->whereMonth('waktu', $month)
                ->whereYear('waktu', $year)
                // ->groupBy(DB::raw('DATE(waktu)'))
                ->orderBy('tanggal', 'asc')
                ->get();



        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'month' => $month,
            'year' => $year,
            // 'date' => now()->format('d-m-Y H:i:s'),
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $ReportResult
        ];

        $pdf = PDF::Loadview('Report.ReportFinalHistory', $data);

        return $pdf->stream('pdf_file.pdf');


    }

    public function reportdaily(){
        $alats = Alat::all();
        return view('Report.ReportDaily',compact('alats'));
    }

    public function reportdailypost(Request $request){
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'dates' => 'required',
            'file' => 'required'
        ]);

        $alat = Alat::where('id_mesin' , $request->id_mesin)->first();
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
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $reportdailyresult
        ];
        if($request->file == 'PDF'){
        $pdf = PDF::Loadview('admin.ReportDailyResult', $data);
        return $pdf->stream('pdf_file.pdf');
        }
        if($request->file == 'CSV'){
            $filename = 'Report_' . $dates . '.csv';

            $headers = [
                'Content-type' => 'text/csv',
                'Content-Disposition' => "attachment; filename\"$filename\"",
            ];

            $columns = [
                'Time',
                'Amount Of Data',
                'Lowest Temperature',
                'Highest Temperature',
                'Lowest Humidity',
                'Highest Humidity',
                'Average Temperature',
                'Average Humidity'
            ];

            $callback = function() use ($sensorData, $columns){
                $file = fopen('php://output','w');
                fwrite($file, implode(',', $columns). "\n");

                foreach ($sensorData as $row){
                    fputs($file, [
                        $row->dates
                    ])
                }
            }
        }
    }


}
