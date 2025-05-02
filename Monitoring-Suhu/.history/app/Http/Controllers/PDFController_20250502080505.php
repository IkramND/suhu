<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Sensor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PDFController extends Controller
{

    public function index(){
        $alats = Alat::all();
        return view('admin.Report',compact('alats'));
    }

    public function generatePDF(Request $request){
        $request->validate([
            'id_mesin' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'file' => 'required'
        ]);

        $alat = Alat::where('id_mesin', $request->id_mesin)->first();

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



        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $alat->ip_address,
            'lokasi' => $alat->lokasi,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            // 'date' => now()->format('d-m-Y H:i:s'),
            'date' => now()->setTimezone('Asia/Jakarta')->format('d-m-Y H:i:s'),// Ganti dengan zona waktu pengguna

            'sensor_data' => $sensorData
        ];

        $pdf = PDF::Loadview('admin.Reportresult', $data);

        return $pdf->stream('pdf_file.pdf');
    }
}
