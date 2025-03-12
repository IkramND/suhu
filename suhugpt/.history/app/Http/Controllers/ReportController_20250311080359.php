<?php

namespace App\Http\Controllers;

use App\Models\ReportResult;
use App\Models\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\alat;


class ReportController extends Controller
{


    public function index(){
        return view('Report.ReportForm');
    }



    public function ReportResult(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|exists:alat,id_mesin',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer'
            // 'ip_address' => 'required|ip',
            // 'lokasi'=> 'required',

        ]);

        $alat = Alat::where('id_mesin',$request->id_mesin)->first();


        // $ReportResult = ReportResult::all()
        // ->where('id_mesin', $request->id_mesin)
        // // ->whereBetween('waktu', [$request->start_date, $request->end_date])
        // ->groupBy(DB::raw('DATE(waktu)'))
        // ->orderBy('waktu', 'asc')
        // ->get();

        $month = (int)$request->month;
        $year = (int)$request->year;

        $ReportResult = ReportResult::selectRaw('DATE(waktu) as tanggal, rata_rata_suhu as rata_rata_suhu, rata_rata_kelembaban as rata_rata_kelembaban')
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
