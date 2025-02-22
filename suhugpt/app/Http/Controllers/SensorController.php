<?php

namespace App\Http\Controllers;

use Dflydev\DotAccessData\Data;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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


    // public function fetchDataHistory(){
    //     // Mengambil data dalam format JSON untuk kebutuhan chart
    //     $data = DB::table('sensor_readings')
    //               ->select('timestamp', 'temperature', 'humidity', 'lokasi')
    //               ->where('lokasi', 'ROB1')
    //               ->orderBy('timestamp', 'desc')// Mengambil data terbaru terlebih dahulu
    //               ->limit(100)
    //               ->get()
    //               ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

    //             //   dd($data);

    //     return response()->json($data->values()); // Mengembalikan dalam format JSON dengan indeks ulang
    // }

    public function fetchDataHistoryROB1(Request $request) {
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');

        $query = DB::table('data_sensor')
            ->where('id_mesin', 'ALAT001');

        // Jika tanggal dipilih, filter berdasarkan tanggal
        if ($start_date && $end_date) {
            $query->whereBetween('waktu', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']);
        }

        $data = $query->orderBy('waktu', 'asc')->get();

        return response()->json($data);
    }



    public function fetchDataHistory_ROB1(){
        // Mengambil data dalam format JSON untuk kebutuhan chart
        $data = DB::table('data_sensor')
                  ->select('waktu', 'suhu', 'kelembaban', 'id_mesin')
                  ->where('id_mesin', 'ALAT001')
                  ->orderBy('waktu', 'desc')// Mengambil data terbaru terlebih dahulu
                //   ->limit(100)
                  ->get()
                  ->reverse(); // Membalik urutan agar data terbaru ada di paling kanan

                //   dd($data);

            return view('History.ROB1', compact('data'));
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
}
