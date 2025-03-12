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
            'id_mesin' => 'required',
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
        $year = 2025;
        $month = 3;

        $ReportResult = ReportResult::where('id_mesin', 'ALAT001')
                        ->whereYear('waktu', $year)
                        ->whereMonth('waktu', $month)
                        ->orderBy('waktu', 'asc')
                        ->get();





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
            // 'date' => now()->format('d-m-Y H:i:s'),
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $ReportResult
        ];

        $pdf = PDF::Loadview('admin.Reportresult', $data);

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
