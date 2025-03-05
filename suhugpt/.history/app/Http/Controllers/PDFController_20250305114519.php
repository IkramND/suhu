<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{

    public function index(){
        return view('admin.report');
    }

    public function generatePDF(Request $request){
        $request->validate([
            'id_mesin' => 'required|string',
            'ip_address' => 'required|ip',
            'lokasi' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);


        $sensorData = Sensor::where('id_mesin', $request->id_mesin)
            ->whereBetween('waktu', [$request->start_date, $request->end_date])
            ->orderBy('waktu', 'asc')
            ->get();

        // $sensorData = Sensor::where('id_mesin',$request->id_mesin)
        //             ->whereBetween('waktu',[$request->start_date,$request->end_date])
        //             ->get();

        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $request->ip_address,
            'lokasi' => $request->lokasi,
            'date' => now()->format('d-m-Y H:i:s'),
            'sensor_data' => $sensorData
        ];

        $pdf = PDF::Loadview('admin.Reportresult', $data);

        return $pdf->stream('pdf_file.pdf');
    }
}
