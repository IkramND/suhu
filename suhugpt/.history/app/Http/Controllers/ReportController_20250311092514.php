<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

use App\Models\ReportResult;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\alat;
use Illuminate\Support\Facades\Mail;



class ReportController extends Controller
{


    public function index(){
        return view('Report.ReportForm');
    }


    public function indexExport(){
    return view('Report.ReportFInalExport', ['step' => 1]);
    }

    public function processStep1(Request $request){
        $request->validate([
            'email' => 'required|email|exist:notification,email',
        ]);

        Session::put('user_email',$request->email);

        return redirect()->route('report.exportStep2');
    }



    public function indexExport2(){
        return view('Report.ReportFInalExport', ['step' => 2]);
    }

    public function processStep2(Request $request){
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $email = Session::get('user_email');

        $alat = Alat::where('id_mesin' $id_mesin)

        if(!$email){
            return redirect()->route('report.export')->withErrors(['email' => 'please enter your email first']);
        }


        $data = [
            'email' => $request->email,
            'id_mesin' => $request->id_mesin,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date
        ];

         // Kirim email (gantilah dengan implementasi email yang sesuai)
         Mail::raw("Laporan telah diminta untuk mesin {$data['id_mesin']} dari {$data['start_date']} sampai {$data['end_date']}.", function ($message) use ($email) {
            $message->to($email)->subject('Permintaan Laporan');
        });

        Session::forget('user_email');

        return redirect()->route('report.export')->with('success', 'Report successfully sent to email!');



    }


    public function ReportResult(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2025'
            // 'ip_address' => 'required|ip',
            // 'lokasi'=> 'required',

        ]);

        $alat = Alat::where('id_mesin',$request->id_mesin)->first();



        $month = (int)$request->month;
        $year = (int)$request->year;

        $ReportResult = ReportResult::selectRaw('DATE(waktu) as tanggal, rata_rata_suhu,rata_rata_kelembaban')
                ->where('id_mesin', $request->id_mesin)
                ->whereMonth('waktu', $month)
                ->whereYear('waktu', $year)
                // ->groupBy(DB::raw('DATE(waktu)'))
                ->orderBy('tanggal', 'asc')
                ->get();


        // $ReportResult = ReportResult::where('id_mesin', $request->id_mesin)
        //                 ->whereMonth('waktu', $month)
        //                 ->whereYear('waktu', $year)
        //                 ->groupBy(DB::raw('DATE(waktu)'))
        //                 ->orderBy('waktu', 'asc')
        //                 ->get();





        // $sensorData = Sensor::where('id_mesin', $request->id_mesin)
        //     ->whereBetween('waktu', [$request->start_date, $request->end_date])
        //     ->orderBy('waktu', 'asc')
        //     ->get();

        // $sensorData = Sensor::where('id_mesin',$request->id_mesin)
        //             ->whereBetween('waktu',[$request->start_date,$request->end_date])
        //             ->get();

        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'month' => $request->month,
            'year' => $request ->year,
            // 'date' => now()->format('d-m-Y H:i:s'),
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $ReportResult
        ];

        $pdf = PDF::Loadview('Report.ReportFinalHistory', $data);

        return $pdf->stream('pdf_file.pdf');


        // $reports = ReportResult::where('id_mesin',$id_mesin);


        // $reports = ReportResult::all();
        // return view('Report.ReportFinalHistory',compact('reports'));

    }

    public function ExportReport(Request $request){
        $request->validate([

        ]);

    }

}
