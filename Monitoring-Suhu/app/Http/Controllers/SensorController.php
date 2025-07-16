<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SensorController extends Controller
{

    public function fetchData(Request $request)
    {
        $id_mesin = $request->input('id_mesin');
        $limit = $request->input('limit', 10);
        $second = $request->input('second', 60);

        $rawData = DB::table('data_sensor')
            ->where('id_mesin', $id_mesin)
            ->orderBy('waktu', 'desc')
            ->limit(2000)
            ->get();

        if ($rawData->isEmpty()) {
            return response()->json([]);
        }

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

            if (count($filtered) >= $limit) {
                break;
            }
        }

        $filtered = array_reverse($filtered);

        return response()->json($filtered);
    }

}
