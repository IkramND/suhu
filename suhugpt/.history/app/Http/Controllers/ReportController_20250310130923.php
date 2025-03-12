<?php

namespace App\Http\Controllers;

use App\Models\ReportResult;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function ReportResult(){
        $data = ReportResult::where();
    }

    public function ExportReport(Request $request){
        $request->validate([

        ]);

    }

}
