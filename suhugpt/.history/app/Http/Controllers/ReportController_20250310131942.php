<?php

namespace App\Http\Controllers;

use App\Models\ReportResult;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ReportResult(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required',
            'ip_address' => 'required|ip',
            'lokasi'=> 'required',
        ]);

        $data[
        'id_mesin' => $request->id_mesin

        ]



        $reports = ReportResult::all();
        return view('Report.ReportFinalHistory',compact('reports'));

    }

    public function ExportReport(Request $request){
        $request->validate([

        ]);

    }

}
