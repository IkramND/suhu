<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Alat;
use App\Models\Calibration;
use App\Models\DataRetention;
use Illuminate\Http\Request;

class SettingController extends Controller
{

    public function index()
    {
        $configurations = Configuration::all();
        return view('admin.Configurationlist', compact('configurations'));
    }

    public function settings()
    {
        $alats = Alat::all();
        return view('admin.Settings', compact('alats'));
    }

    public function configuration(Request $request)
    {
        $request->validate([
            'id_mesin' => 'required|string',
            'batas_atas_suhu' => 'required|numeric',
            'batas_bawah_suhu' => 'required|numeric',
            'batas_atas_kelembaban' => 'required|numeric',
            'batas_bawah_kelembaban' => 'required|numeric',
        ]);

        if (Configuration::where('id_mesin', $request->id_mesin)->exists()) {
            return redirect()->back()->withErrors(['id_mesin' => '* Machine ID already in use']);
        }

        Configuration::create([
            'id_mesin' => $request->id_mesin,
            'batas_atas_suhu' => $request->batas_atas_suhu,
            'batas_bawah_suhu' => $request->batas_bawah_suhu,
            'batas_atas_kelembaban' => $request->batas_atas_kelembaban,
            'batas_bawah_kelembaban' => $request->batas_bawah_kelembaban

        ]);
        return redirect()->route('configuration.list')->with('success', 'success');
    }

    public function listconfiguration()
    {
        $configurations = Configuration::all();
        return view('admin.Configurationlist', compact('configurations'));
    }

    function edit($id)
    {
        $configuration = Configuration::findOrFail($id);

        return view('admin.editconfiguration', compact('configuration'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_mesin' => 'required|string',
            'batas_atas_suhu' => 'required|numeric',
            'batas_bawah_suhu' => 'required|numeric',
            'batas_atas_kelembaban' => 'required|numeric',
            'batas_bawah_kelembaban' => 'required|numeric',
        ]);

        $configuration = Configuration::findOrFail($id);
        $configuration->update($request->all());

        return redirect()->route('configuration.list')->with('success', 'success');
    }


    public function destroy($id)
    {
        $configuration = Configuration::findOrFail($id);
        $configuration->delete();
        return redirect()->route('configuration.list')->with('success', 'success');
    }

    public function addcalibration(){
        $alats = Alat::all();
        return view('admin.addcalibration',compact('alats'));
    }

    public function addscalibration(Request $request){
        $request->validate([
            'id_mesin' =>  'required|string',
            'temperature_calibration' => 'required|numeric',
            'humidity_calibration' => 'required|numeric'
            ]);

        if(Calibration::where('id_mesin', $request->id_mesin)->exists()){
            // return redirect()->back()->withErrors()
            return redirect()->back()->withErrors(['id_mesin' => '* Machine ID already in use']);
        }

        Calibration::create([
            'id_mesin' => $request->id_mesin,
            'temperature_calibration' => $request->temperature_calibration,
            'humidity_calibration' => $request->humidity_calibration
        ]);

        return redirect()->route('calibration.list')->with('success','success');


    }

    public function calibrationlist(){
        $calibrations = Calibration::all();
        return view('admin.listcalibration',compact('calibrations'));
    }

    public function editcalibration($id){

        $calibrations = Calibration::findOrFail($id);


        return view('admin.editcalibration',compact('calibrations'));

    }

    public function updatecalibration(Request $request,$id){
        $request->validate([
            'id_mesin' => 'required|string',
            'temperature_calibration' => 'required|numeric',
            'humidity_calibration' => 'required|numeric'
        ]);

        $calibrations = Calibration::findOrFail($id);
        $calibrations->update($request->all());

        return redirect()->route('calibration.list')->with('success', 'success');
    }

    public function deletecalibration($id){
        $calibrations = Calibration::findOrFail($id);
        $calibrations->delete();
        return redirect()->route('calibration.list')->with('success','success');

    }

    public function adddataretention(){

        if(!DataRetention::exists()){
        return view('admin.adddataretention');
        }else{
            $dataretentions = DataRetention::all();
            return view('admin.dataretention', compact('dataretentions'));
        }
    }

    public function addsdataretention(Request $request){
        $request->validate([
            'year' => 'required|integer|max_digits:3'
        ]);

        DataRetention::create([
            'year' => $request->year
        ]);

        return redirect()->route('dataretention');

    }

    public function dataretention(){
        $dataretentions = DataRetention::all();
        return view('admin.dataretention', compact('dataretentions'));
    }

    public function editdataretention($id){
        $dataretention = DataRetention::findOrFail($id);

        return view('admin.editdataretention', compact('dataretention'));

    }

    public function updatedataretention(Request $request, $id){

        $request->validate([
            'year' => 'required|integer|max_digits:3'
        ]);


        $dataretention = DataRetention::findOrFail($id);

        $dataretention->update($request->all());

        return redirect()->route('dataretention');

    }


}
