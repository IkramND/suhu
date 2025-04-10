<?php

namespace App\Http\Controllers;

use App\Models\SensorDatas;
use Dflydev\DotAccessData\Data;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\alat;

use function Laravel\Prompts\select;
use function Laravel\Prompts\table;

// use DB; // Menggunakan Query Builder untuk database

class SensorController extends Controller
{




    public function index(){

        // $lokasi = $request->input('lokasi', '');
        // Mengambil data suhu dan kelembaban dari database
        $data = DB::table('sensor_readings')
                  ->select('timestamp', 'temperature', 'humidity', 'lokasi')
                  ->orderBy('timestamp', 'desc')
                  ->limit(100) // Misalnya mengambil 100 data terakhir
                  ->get();

        return view('sensor.indexx', compact('data'));
    }









    public function fetchHistory(Request $request)
    {
        $id_mesin = $request->input('id_mesin');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $data =DB::table('data_sensor')->where('id_mesin', $id_mesin)
                          ->whereBetween('waktu', [$start_date, $end_date])
                          ->get();
        return response()->json($data);
    }




    public function fetchData(Request $request)
{
    $id_mesin = $request->input('id_mesin');
    $limit = $request->input('limit'); // Default 10 jika tidak ada input
    $second = $request->input('second'); // Default 900 detik (15 menit)

    $data = DB::table('data_sensor')
        ->where('id_mesin', $id_mesin)
        ->whereRaw('MOD(TIME_TO_SEC(TIME(waktu)) - TIME_TO_SEC(TIME((SELECT MIN(waktu) FROM data_sensor))), ?) = 0', [$second]) // Filter waktu berdasarkan interval detik
        ->orderBy('waktu', 'desc') // Ambil data terbaru dulu
        ->limit($limit) // Ambil data terbatas sesuai permintaan
        ->get();

    return response()->json(collect($data)->reverse()->values()); // Reverse setelah konversi ke Collection
}

    // public function fetchDataByIdMesin($id_mesin)
    // {
    //     $data = DB::table('sensor_data')
    //         ->where('id_mesin', $id_mesin)
    //         ->orderBy('waktu', 'desc')
    //         ->take(10) // Ambil 10 data terbaru
    //         ->get();

    //     return response()->json($data);
    // }



    public function fetchDataHistory(Request $request, $id_mesin)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $cekMesin = DB::table('data_sensor')->where('id_mesin', $id_mesin)->exists();
    if (!$cekMesin) {
        return response()->json(['message' => 'ID Mesin tidak ditemukan'], 400);
    }

    $query = DB::table('data_sensor')
    ->selectRaw("DATE(waktu) as tanggal,
                DATE_FORMAT(MIN(waktu), '%W') as hari,
                LEFT(AVG(suhu), 4) as rata_rata_suhu,
                LEFT(AVG(kelembaban), 4) as rata_rata_kelembaban")
    ->where('id_mesin', $id_mesin) // Gunakan id_mesin dari input user
    ->groupBy(DB::raw('DATE(waktu)'))
    ->orderBy('tanggal', 'ASC');

    if ($startDate && $endDate) {
        $query->whereBetween('waktu', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
    }

    $data = $query->get();

    return response()->json($data);
}


    public function getIpAddress(Request $request)
    {
        // Ambil data IP berdasarkan alat_id = 'ALAT001'
        $ipAddress = Alat::where('id_mesin', 'ALAT001')->value('ip_address');

        // Kembalikan dalam format JSON
        return response()->json(['ip_address' => $ipAddress]);
    }

    public function SensorPage(Request $request){
        $lokasi = $request->input('lokasi','memuat...');
        $ip = $request->input('ip', 'memuat');
        $id_mesin = $request->input('id_mesin', 'memuat');

        $alat = alat::where('ip_address',$request->ip)
                ->where('lokasi',$request->lokasi)
                ->where('id_mesin', $request->id_mesin)
                ->first();

        if (!$alat) {
        // Tindakan jika tidak ditemukan, misalnya:
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        return view('HistoryPage',compact('lokasi','ip','id_mesin'));
    }



}
