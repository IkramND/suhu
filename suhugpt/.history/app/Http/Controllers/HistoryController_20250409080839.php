<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $id_mesin = $request->query('id_mesin');
        $ip_address = $request->query('ip_address');
        $historyData = DB::table('data_sensor')->where('id_mesin', $id_mesin)->orderBy('waktu', 'desc')->get();
        return view('Historys', compact('historyData', 'id_mesin','ip_address'));
    }

    public function SensorPage(Request $request){
        $lokasi = $request->input('lokasi','memuat...');
        $ip = $request->input('ip', 'memuat');
        $id_mesin = $request->input('id_mesin', 'memuat');


        return view('HistoryPage',compact('lokasi','ip','id_mesin'));
    }



public function fetchHistory(Request $request)
{
    $id_mesin = $request->query('id_mesin');

    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = DB::table('data_sensor')
    ->selectRaw("DATE(waktu) as tanggal,
                 DATE_FORMAT(MIN(waktu), '%W') as hari,
                 LEFT(AVG(suhu), 4) as rata_rata_suhu,
                 LEFT(AVG(kelembaban), 4) as rata_rata_kelembaban")
    ->where('id_mesin', $id_mesin)
    ->groupBy(DB::raw('DATE(waktu)'))
    ->orderBy('tanggal', 'ASC');



    if ($startDate && $endDate) {
        $query->whereBetween('waktu', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
    }

    $data = $query->get();

    return response()->json($data);
}
}
