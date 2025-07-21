<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class CardController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|string|unique:alat,id_mesin',
            'ip_address' => 'required|ip',
            'lokasi' => 'required|string|max:20'
        ], [
            'id_mesin.unique' => '* Machine ID already exist'
        ]);
        Alat::create([
            'id_mesin' => $request->id_mesin,
            'ip_address' => $request->ip_address,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('card.index')->with('success', 'success');
    }


    public function index()
    {

        $alats = DB::select("
            SELECT a.*,
                   CASE
                       WHEN b.id_mesin IS NOT NULL THEN 'Active'
                       ELSE 'Inactive'
                   END AS status
            FROM alat a
            LEFT JOIN (
                SELECT id_mesin, MAX(id) AS latest_id
                FROM data_sensor
                WHERE waktu BETWEEN NOW() - INTERVAL 5 MINUTE AND NOW() + INTERVAL 5 MINUTE
                GROUP BY id_mesin
            ) b ON a.id_mesin = b.id_mesin;
        ");

        return view('admin.indexing', compact('alats'));
    }

       public function index2()
    {

        $alats = DB::select("
            SELECT a.*,
                   CASE
                       WHEN b.id_mesin IS NOT NULL THEN 'Active'
                       ELSE 'Inactive'
                   END AS status
            FROM alat a
            LEFT JOIN (
                SELECT id_mesin, MAX(id) AS latest_id
                FROM data_sensor
                WHERE waktu BETWEEN NOW() - INTERVAL 5 MINUTE AND NOW() + INTERVAL 5 MINUTE
                GROUP BY id_mesin
            ) b ON a.id_mesin = b.id_mesin;
        ");




        return view('admin.indexing2', compact('alats'));
    }




    public function lastupdate()
    {


        $lastupdate = DB::table('data_sensor')
            ->select('suhu', 'kelembaban', 'waktu')
            ->latest()
            ->first();

        return response()->json($lastupdate);
    }



    public function getLastSensorData(Request $request)
    {
        $id_mesin = $request->id_mesin;

        $latestData = DB::table('sensor_data')
            ->where('id_mesin', $id_mesin)
            ->orderBy('waktu', 'desc')
            ->first();

        return response()->json($latestData);
    }

    public function getAlats()
    {
        $alats = DB::select("
        SELECT a.*,
               CASE
                   WHEN b.id_mesin IS NOT NULL THEN 'Active'
                   ELSE 'Inactive'
               END AS status
        FROM alat a
        LEFT JOIN (
            SELECT id_mesin, MAX(id) AS latest_id
            FROM data_sensor
            WHERE waktu BETWEEN NOW() - INTERVAL 5 MINUTE AND NOW() + INTERVAL 5 MINUTE
            GROUP BY id_mesin
        ) b ON a.id_mesin = b.id_mesin;
    ");

        return response()->json($alats);
    }


    public function dashboard()
    {

        $userId = Auth::id(); // ambil ID user yang login
        $user = User::findOrFail($userId);

        $accessIds = json_decode($user->acess, true);

        $users = Auth::user();

        if ($users->role->role === 'Admin' || $users->role->role === 'admin') {
            $alats = DB::select("
            SELECT a.*,
             CASE
                   WHEN b.id_mesin IS NOT NULL THEN 'Active'
                   ELSE 'Inactive'
               END AS status
            FROM alat a
            LEFT JOIN (
                SELECT id_mesin, MAX(id) AS latest_id
                FROM data_sensor
                WHERE waktu BETWEEN NOW() - INTERVAL 5 MINUTE AND NOW() + INTERVAL 5 MINUTE
                GROUP BY id_mesin
            ) b ON a.id_mesin = b.id_mesin;
        ");
            return view('admin.indexing', compact('alats'));
        }

        if (!is_array($accessIds)) {
            $accessIds = [];
        }

        $alats = DB::table('alat as a')
            ->leftJoin(DB::raw('(
                SELECT id_mesin, MAX(id) as latest_id
                FROM data_sensor
                WHERE waktu BETWEEN NOW() - INTERVAL 5 MINUTE AND NOW()
                GROUP BY id_mesin
            ) as b'), 'a.id_mesin', '=', 'b.id_mesin')
            ->select('a.*', DB::raw("CASE WHEN b.id_mesin IS NOT NULL THEN 'Active' ELSE 'Inactive' END as status"))
            ->whereIn('a.id_mesin', $accessIds)
            ->get();

        return view('utama', compact('alats'));
    }


    function edit($id)
    {
        $alat = Alat::findOrFail($id);

        return view('admin.edit', compact('alat'));
    }

    public function Editalat($id)
    {
        $alat = Alat::findOrFail($id);

        return view('admin.Editalat', compact('alat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mesin' => 'required',
            'ip_address' => 'required',
            'lokasi' => 'required'
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update($request->all());

        return redirect()->route('card.index')->with('success', 'success');
    }


    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);
        $alat->delete();
        return redirect()->route('card.index')->with('success', 'success');
    }



    public function indexlist()
    {
        $alats = Alat::all();
        return view('admin.Alatlist', compact('alats'));
    }

    public function utama2(){
    $alats = Alat::all();
    return view('utama2', compact('alats'));
    }
}
