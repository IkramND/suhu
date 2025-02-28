<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;

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
    $alats = Alat::all();
    return view('admin.indexing',compact('alats'));
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
        return view('admin.editalat',compact('alats'));
    }

    // public function index(){
    //     $alats = Alat::all();
    //     return view('admin.indexing',compact('alats'));
    //     }



}
