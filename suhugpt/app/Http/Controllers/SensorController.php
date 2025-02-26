<?php

namespace App\Http\Controllers;

use App\Models\SensorDatas;
use Dflydev\DotAccessData\Data;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\alat;

use function Laravel\Prompts\select;

// use DB; // Menggunakan Query Builder untuk database

class SensorController extends Controller
{


    public function index(Request $request)
    {
        // Mengambil parameter dari request
        $tanggal_awal = $request->input('tanggal_awal');
        $tanggal_akhir = $request->input('tanggal_akhir');
        $lokasi = $request->input('lokasi', ''); // Default ROB1

        // Mengambil data dari database dengan Query Builder
        $data = DB::table('sensor_readings')
                  ->whereBetween('timestamp', [$tanggal_awal, $tanggal_akhir])
                  ->where('lokasi', $lokasi)
                  ->get();

        // Mengirim data ke view
        return view('sensor.index', compact('data', 'tanggal_awal', 'tanggal_akhir', 'lokasi'));
    }

    // public function store(Request $request)
    // {
    //     // Validasi data yang dikirim dari Arduino
    //     $request->validate([
    //         'id_mesin' => 'required|string',
    //         'suhu' => 'required|numeric',
    //         'kelembaban' => 'required|numeric',
    //         'waktu' => 'required|date_format:Y-m-d H:i:s',
    //     ]);

    //     // Simpan data ke database
    //     SensorDatas::create([
    //         'id_mesin' => $request->id_mesin,
    //         'suhu' => $request->suhu,
    //         'kelembaban' => $request->kelembaban,
    //         'waktu' => $request->waktu,
    //     ]);

    //     return response()->json(['message' => 'Data berhasil disimpan'], 201);
    // }

    public function indexx(){

        // $lokasi = $request->input('lokasi', '');
        // Mengambil data suhu dan kelembaban dari database
        $data = DB::table('sensor_readings')
                  ->select('timestamp', 'temperature', 'humidity', 'lokasi')
                  ->orderBy('timestamp', 'desc')
                  ->limit(100) // Misalnya mengambil 100 data terakhir
                  ->get();

        return view('sensor.indexx', compact('data'));
    }

    // public function FetchDataLokasi(Request $request){
    //     $lokasi = $request->query('lokasi', '');

    //     $lokasi = $request->input('lokasi');
    //     $data = DB::table('sensor_readings')
    //                 ->select('timestamp','temperature','humidity','lokasi')
    //                 ->where('lokasi', $lokasi)
    //                 ->orderBy('timestamp', 'desc')
    //                 ->Limit('100')
    //                 ->get()
    //                 ->reverse();

    //     // $data = $data->where('lokasi', $lokasi);
    //     return response()->json($data);
    //     }




public function fetchDataHistoryROB1(Request $request)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');

    $query = DB::table('data_sensor')
    ->selectRaw("DATE(waktu) as tanggal,
                 DATE_FORMAT(MIN(waktu), '%W') as hari,
                 LEFT(AVG(suhu), 4) as rata_rata_suhu,
                 LEFT(AVG(kelembaban), 4) as rata_rata_kelembaban")
    ->where('id_mesin', 'ALAT001')
    ->groupBy(DB::raw('DATE(waktu)'))
    ->orderBy('tanggal', 'ASC');



    if ($startDate && $endDate) {
        $query->whereBetween('waktu', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
    }

    $data = $query->get();

    return response()->json($data);
}


    // public function fetchDataHistoryROB1(Request $request) {
    //     $start_date = $request->input('start_date');
    //     $end_date = $request->input('end_date');

    //     $query = DB::table('data_sensor')
    //         ->where('id_mesin', 'ALAT001');

    //     // Jika tanggal dipilih, filter berdasarkan tanggal
    //     if ($start_date && $end_date) {
    //         $query->whereBetween('waktu', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
    //     }

    //     $data = $query->orderBy('waktu', 'asc')->get();

    //     return response()->json($data);
    // }



    public function fetchDataHistory_ROB1(){
        // // Mengambil data dalam format JSON untuk kebutuhan chart
        // $data = DB::table('data_sensor')
        //           ->select('waktu', 'suhu', 'kelembaban', 'id_mesin')
        //           ->where('id_mesin', 'ALAT001')
        //           ->orderBy('waktu', 'desc')// Mengambil data terbaru terlebih dahulu
        //         //   ->limit(100)
        //           ->get()
        //           ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

        //         //   dd($data);

            return view('History.ROB1');
            }

    public function fetchDataHistoryROB2(){
        // Mengambil data dalam format JSON untuk kebutuhan chart
        $data = DB::table('sensor_readings')
                  ->select('timestamp', 'temperature', 'humidity', 'lokasi')
                  ->where('lokasi', 'ROB2')
                  ->orderBy('timestamp', 'desc')// Mengambil data terbaru terlebih dahulu
                  ->limit(100)
                  ->get()
                  ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

                //   dd($data);

        return response()->json($data->values()); // Mengembalikan dalam format JSON dengan indeks ulang
    }
    public function fetchDataHistory_ROB2(){
        // Mengambil data dalam format JSON untuk kebutuhan chart
        $data = DB::table('sensor_readings')
                  ->select('timestamp', 'temperature', 'humidity', 'lokasi')
                  ->where('lokasi', 'ROB2')
                  ->orderBy('timestamp', 'desc')// Mengambil data terbaru terlebih dahulu
                  ->limit(100)
                  ->get()
                  ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

                //   dd($data);

        return view('History.ROB2', compact('data'));
            }

    public function fetchDataHistoryROB3(){
        // Mengambil data dalam format JSON untuk kebutuhan chart
        $data = DB::table('sensor_readings')
                  ->select('timestamp', 'temperature', 'humidity', 'lokasi')
                  ->where('lokasi', 'ROB3')
                  ->orderBy('timestamp', 'desc')// Mengambil data terbaru terlebih dahulu
                  ->limit(100)
                  ->get()
                  ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

                //   dd($data);

        return response()->json($data->values()); // Mengembalikan dalam format JSON dengan indeks ulang
    }



    public function fetchData(){
        // Mengambil data dalam format JSON untuk kebutuhan chart
        $data = DB::table('data_sensor')
                  ->select('id_mesin', 'suhu', 'kelembaban', 'waktu')
                  ->orderBy('waktu', 'desc') // Mengambil data terbaru terlebih dahulu
                  ->limit(15)
                  ->get()
                  ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

        return response()->json($data->values()); // Mengembalikan dalam format JSON dengan indeks ulang
    }

    // public function fetchDatas(Request $request,$id_mesin){
    // $startDate = $request->input('start_date');
    // $endDate = $request->input('end_date');
    // $idMesin = $request->input('id_mesin'); // Ambil ID mesin dari request

    // // Pastikan id_mesin dikirim
    // if (!$idMesin) {
    //     return response()->json(['message' => 'ID Mesin tidak ditemukan'], 400);
    // }

    // // Query data berdasarkan id_mesin yang diberikan user
    // $query = DB::table('data_sensor')
    //     ->selectRaw("DATE(waktu) as tanggal,
    //                  DATE_FORMAT(MIN(waktu), '%W') as hari,
    //                  LEFT(AVG(suhu), 4) as rata_rata_suhu,
    //                  LEFT(AVG(kelembaban), 4) as rata_rata_kelembaban")
    //     ->where('id_mesin', $idMesin) // Sesuai dengan input user
    //     ->groupBy(DB::raw('DATE(waktu)'))
    //     ->orderBy('tanggal', 'ASC');

    // // Jika ada filter tanggal, tambahkan kondisi WHERE
    // if ($startDate && $endDate) {
    //     $query->whereBetween('waktu', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
    // }

    // $data = $query->get();

    // // Jika data kosong, kembalikan response dengan status 404
    // if ($data->isEmpty()) {
    //     return response()->json(['message' => 'Data tidak ditemukan'], 404);
    // }

    // return response()->json($data);







    //     // // Mengambil data dalam format JSON untuk kebutuhan chart
    //     // $data = DB::table('data_sensor')->select('waktu', 'kelembaban', 'id_mesin')
    //     // ->where('id_mesin', $id_mesin)
    //     // ->orderBy('waktu', 'desc')
    //     // ->get()
    //     // ->reverse();

    //     // return response()->json($data);
    // }



    public function fetchDataHistory(Request $request, $id_mesin)
{
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    // $idMesin = $request->input('id_mesin'); // Ambil id_mesin dari input user

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


//     public function fetchDataHistory(Request $request, $id_mesin)
// {
//     $startDate = $request->input('start_date');
//     $endDate = $request->input('end_date');

//     // Cek apakah ID Mesin ada di database
//     $cekMesin = DB::table('data_sensor')->where('id_mesin', $id_mesin)->exists();

//     if (!$cekMesin) {
//         return response()->json(["message" => "ID Mesin tidak ditemukan"], 404);
//     }

//     $query = DB::table('data_sensor')
//         ->selectRaw("DATE(waktu) as tanggal,
//                      DATE_FORMAT(MIN(waktu), '%W') as hari,
//                      LEFT(AVG(suhu), 4) as rata_rata_suhu,
//                      LEFT(AVG(kelembaban), 4) as rata_rata_kelembaban")
//         ->where('id_mesin', $id_mesin)
//         ->whereNotNull('waktu') // Filter hanya data dengan waktu yang valid

//         ->groupBy(DB::raw('DATE(waktu)'))
//         ->orderBy('tanggal', 'ASC');

//     if ($startDate && $endDate) {
//         $query->whereBetween('waktu', [$startDate . " 00:00:00", $endDate . " 23:59:59"]);
//     }

//     $data = $query->get();

//     // Jika data kosong, berikan pesan
//     if ($data->isEmpty()) {
//         return response()->json(["message" => "Data tidak ditemukan untuk ID Mesin ini"], 404);
//     }

//     return response()->json($data);
// }

// public function fetchDataHistory($id_mesin, Request $request)
// {
//     $startDate = $request->input('start_date');
//     $endDate = $request->input('end_date');

//     $query = DB::table('data_sensor')
//         ->where('id_mesin', $id_mesin);

//     if ($startDate && $endDate) {
//         $query->whereBetween('waktu', [$startDate, $endDate]);
//     }

//     $data = $query->get(['waktu', 'id_mesin', 'suhu', 'kelembaban']);

//     if ($data->isEmpty()) {
//         return response()->json(["message" => "Tidak ada data"], 404);
//     }

//     return response()->json($data);
// }














    public function getIpAddress(Request $request)
    {
        // Ambil data IP berdasarkan alat_id = 'ALAT001'
        $ipAddress = Alat::where('id_mesin', 'ALAT001')->value('ip_address');

        // Kembalikan dalam format JSON
        return response()->json(['ip_address' => $ipAddress]);
    }

    public function getLokasiAlat(Request $request)
    {
        // Ambil lokasi berdasarkan alat_id = 'ALAT001'
        $lokasiAlat = Alat::where('id_mesin', 'ALAT001')->value('lokasi');

        // Kembalikan dalam format JSON
        return response()->json(['lokasi' => $lokasiAlat]);
    }



    public function SensorPage(Request $request){
        $lokasi = $request->input('lokasi','memuat...');
        $ip = $request->input('ip', 'memuat');
        $id_mesin = $request->input('id_mesin', 'memuat');

        $alat = alat::where('ip_addres',$request->ip_address)
                    ->where('lokasi',$request->lokasi)
                    ->where('id_mesin', $request->id_mesin)
                    ->first();

        return view('HistoryPage',compact('lokasi','ip','id_mesin'));
    }

    public function chose(){
        return view('PilihHistory');
    }

//     public function show($id)
// {
//     $alat = Alat::findOrFail($id); // Ambil data alat berdasarkan ID
//     return view('alat.show', compact('alat'));
// }
}
