<?php

namespace App\Http\Controllers;
use App\Models\Configuration;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index(){
        $configurations = Configuration::all();
        return view('admin.Configurationlist',compact('configurations'));
    }

    public function settings(){
        return view('admin.Settings');
    }

    public function configuration(Request $request){
        $request->validate([
            'id_mesin' =>'required|string',
            'batas_atas_suhu' => 'required|numeric',
            'batas_bawah_suhu' => 'required|numeric',
            'batas_atas_kelembaban' => 'required|numeric',
            'batas_bawah_kelembaban' => 'required|numeric',
        ]);

        if (Configuration::where('id_mesin', $request->id_mesin)->exists()) {
            return redirect()->back()->withErrors(['id_mesin' => '* Machine ID already in use']);
        }
        $configuration = Configuration::create([
            'id_mesin' => $request->id_mesin,
            'batas_atas_suhu' => $request->batas_atas_suhu,
            'batas_bawah_suhu' => $request->batas_bawah_suhu,
            'batas_atas_kelembaban' => $request->batas_atas_kelembaban,
            'batas_bawah_kelembaban' => $request->batas_bawah_kelembaban

        ]);
        return redirect()->route('configuration.list')->with('success','Alat berhasil ditambahkan');

    }

    public function listconfiguration(){
        $configurations = Configuration::all();
        return view('admin.Configurationlist',compact('configurations'));
    }

    function edit($id){
        $configuration = Configuration::findOrFail($id);

        return view('admin.editconfiguration',compact('configuration'));
    }

    public function update(Request $request, $id){
        $request->validate([
           'id_mesin' =>'required|string',
            'batas_atas_suhu' => 'required|numeric',
            'batas_bawah_suhu' => 'required|numeric',
            'batas_atas_kelembaban' => 'required|numeric',
            'batas_bawah_kelembaban' => 'required|numeric',
        ]);

        $configuration = Configuration::findOrFail($id);
        $configuration -> update($request->all());

        return redirect()->route('configuration.list')->with('success','Data alat berhasil diupdate');
    }


    public function destroy($id){
        $configuration = Configuration::findOrFail($id);
        $configuration->delete();
        return redirect()->route('configuration.list')->with('success','Data alat berhasil dihapus');
    }
}
