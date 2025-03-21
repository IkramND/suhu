<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Sensor;
use Illuminate\Support\Facades\DB;


class CardController extends Controller
{
    public function create(){
        return view('admin.create');
    }

    public function store(Request $request){
        $request->validate([
            'id_mesin' => 'required|string|unique:alat,id_mesin',
            'ip_address' =>'required|ip',
            'lokasi' => 'required|string|max:20'
        ]);
        // dd($request->all());
        Alat::create([
            'id_mesin' => $request->id_mesin,
            'ip_address' => $request->ip_address,
            'lokasi' => $request->lokasi
        ]);

        return redirect()->route('card.index')->with('success','Alat berhasil ditambahkan');

    }


    public function index(){

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




    // $alats = Alat::all();
    return view('admin.indexing',compact('alats'));
    }

    public function lastupdate(){


        $lastupdate = DB::table('data_sensor')->select('suhu','kelembaban','waktu')->where('id_mesin','ALAT001')->orderBy('id');

        return response()->json($lastupdate);

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
        // while (true)
        // {
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


            return view('TampilanUtama',compact('alats'));
        // }

    }


    function edit($id){
        $alat = Alat::findOrFail($id);

        return view('admin.edit',compact('alat'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'id_mesin' => 'required',
            'ip_address' => 'required',
            'lokasi' => 'required'
        ]);

        $alat = Alat::findOrFail($id);
        $alat -> update($request->all());

        return redirect()->route('card.index')->with('success','Data alat berhasil diupdate');
    }


    public function destroy($id){
        $alat = Alat::findOrFail($id);
        $alat->delete();
        return redirect()->route('card.index')->with('success','Data alat berhasil dihapus');
    }

    public function Editalat(){
        $alats = Alat::all();
        return view('admin.Editalat',compact('alats'));
    }

    public function indexlist(){
        $alats = Alat::all();
        return view('admin.Alatlist',compact('alats'));
        }



}
