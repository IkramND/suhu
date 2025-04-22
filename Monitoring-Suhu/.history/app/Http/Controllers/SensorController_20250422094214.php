<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\alat;

use function Laravel\Prompts\select;
use function Laravel\Prompts\table;

class SensorController extends Controller
{

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
        $limit = $request->input('limit', 10);
        $second = $request->input('second', 60);

        $rawData = DB::table('data_sensor')
            ->where('id_mesin', $id_mesin)
            ->orderBy('waktu', 'desc')
            ->get();

        if ($rawData->isEmpty()) {
            return response()->json([]);
        }

        // Ambil data yang berjarak ~interval second
        $filtered = [];
        $lastTime = null;

        foreach ($rawData as $data) {
            if ($lastTime === null) {
                $filtered[] = $data;
                $lastTime = strtotime($data->waktu);
            } else {
                $current = strtotime($data->waktu);
                if (abs($lastTime - $current) >= $second) {
                    $filtered[] = $data;
                    $lastTime = $current;
                }
            }

            // Hentikan jika sudah cukup
            if (count($filtered) >= $limit) {
                break;
            }
        }

        // Karena kita ambil dari data terbaru, balikkan supaya dari lama ke baru
        $filtered = array_reverse($filtered);

        return response()->json($filtered);
    }


    // public function fetchData(Request $request)
    // {
    //     $id_mesin = $request->input('id_mesin');
    //     $limit = $request->input('limit', 10); // default 10
    //     $second = $request->input('second', 60); // default 60 detik

    //     // Ambil waktu referensi paling awal
    //     $minTime = DB::table('data_sensor')
    //         ->where('id_mesin', $id_mesin)
    //         ->min('waktu');

    //     // Ambil data berdasarkan selisih waktu yang cocok dengan second
    //     $data = DB::table('data_sensor')
    //         ->where('id_mesin', $id_mesin)
    //         ->whereRaw('MOD(TIME_TO_SEC(TIMEDIFF(waktu, ?)), ?) = 0', [$minTime, $second])
    //         ->orderBy('waktu', 'desc')
    //         ->limit($limit)
    //         ->get();

    //     // Jika data kosong, ambil data terdekat dari interval second
    //     if ($data->isEmpty()) {
    //         $data = DB::table('data_sensor')
    //             ->where('id_mesin', $id_mesin)
    //             ->orderByRaw('ABS(MOD(TIME_TO_SEC(TIMEDIFF(waktu, ?)), ?))', [$minTime, $second])
    //             ->orderBy('waktu', 'desc')
    //             ->limit($limit)
    //             ->get();
    //     }

    //     return response()->json($data->reverse()->values()); // urutkan dari lama ke baru
    // }


    //real

//     public function fetchData(Request $request)
// {
//     $id_mesin = $request->input('id_mesin');
//     $limit = $request->input('limit');
//     $second = $request->input('second');

//     $data = DB::table('data_sensor')
//         ->where('id_mesin', $id_mesin)
//         ->whereRaw('MOD(TIME_TO_SEC(TIME(waktu)) - TIME_TO_SEC(TIME((SELECT MIN(waktu) FROM data_sensor))), ?) = 0', [$second]) // Filter waktu berdasarkan interval detik
//         ->orderBy('waktu', 'desc') // Ambil data terbaru dulu
//         ->limit($limit) // Ambil data terbatas sesuai permintaan
//         ->get();

//     if($data->isEmpty()){
//         $data = DB::table('data_sensor')
//         ->select('*')
//         ->where('id_mesin',$id_mesin)
//         ->orderByRaw('ABS(MOD(TIME_TO_SEC(TIME(waktu)) - TIME_TO_SEC(TIME((SELECT MIN(waktu) FROM data_sensor))), ?) = 0', [$second])
//         ->orderBy('waktu')
//         ->get();
//     }

//     return response()->json(collect($data)->reverse()->values()); // Reverse setelah konversi ke Collection
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



    // public function SensorPage(Request $request){
    //     $lokasi = $request->input('lokasi','memuat...');
    //     $ip = $request->input('ip', 'memuat');
    //     $id_mesin = $request->input('id_mesin', 'memuat');

    //     $alat = alat::where('ip_address',$request->ip)
    //             ->where('lokasi',$request->lokasi)
    //             ->where('id_mesin', $request->id_mesin)
    //             ->first();

    //     if (!$alat) {
    //     // Tindakan jika tidak ditemukan, misalnya:
    //         return redirect()->back()->with('error', 'Data tidak ditemukan.');
    //     }

    //     return view('HistoryPage',compact('lokasi','ip','id_mesin'));
    // }



}
