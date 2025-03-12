<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PDFController extends Controller
{

    public function index(){
        return view('admin.report');
    }

    public function generatePDF(Request $request){
        $request->validate([
            'id_mesin' => 'required|string',
            // 'ip_address' => 'required|ip',
            // 'lokasi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $alat = Alat::where('id_mesin', $request->id_mesin)->first();




        $sensorData = Sensor::select(
            DB::raw('DATE(waktu) as tanggal'),
            // DB::raw('SUM(suhu) as total_suhu'),
            // DB::raw('SUM(kelembaban) as total_kelembaban'),
            DB::raw('COUNT(*) as jumlah_data'),
            DB::raw('AVG(suhu) as rata_rata_suhu'),
            DB::raw('AVG(kelembaban) as rata_rata_kelembaban')
        )
        ->where('id_mesin', $request->id_mesin)
        ->whereBetween('waktu', [$request->start_date, $request->end_date])
        ->groupBy(DB::raw('DATE(waktu)'))
        ->orderBy('tanggal', 'asc')
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
            'ip_address' => $request->ip_address,
            'lokasi' => $request->lokasi,
            // 'date' => now()->format('d-m-Y H:i:s'),
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $sensorData
        ];

        $pdf = PDF::Loadview('admin.Reportresult', $data);

        return $pdf->stream('pdf_file.pdf');
    }
}
