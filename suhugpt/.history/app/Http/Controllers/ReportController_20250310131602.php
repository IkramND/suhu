<?php

namespace App\Http\Controllers;

use App\Models\ReportResult;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ReportResult(){
        $reports = ReportResult::all();
        return view('Report.ReportFinalHistory',compact('reports'));

    }

    public function ExportReport(Request $request){
        $request->validate([

        ]);

    }

}
