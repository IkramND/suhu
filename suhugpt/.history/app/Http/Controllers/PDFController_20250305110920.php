<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{

    public function index(){
        return view('admin.report');
    }

    public function generatePDF(Request $request){
        $request->validate([
            'id_mesin' => 'required',
            'ip_address' => 'required',
            'lokasi' => 'required'
        ]);

        $data = [
            'id_mesin' => $request->id_mesin,
            'ip_address' => $request->ip_address,
            'lokasi' => $request->lokasi,
            'date' => now()->format('d-m-Y H:i:s')
        ];

        $pdf = PDF::Loadview('admin.Reportresult', $data);

        return $pdf->stream('pdf_file.pdf');
    }
}
