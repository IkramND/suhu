<?php

namespace App\Http\Controllers;
use App\Models\alat;
use Illuminate\Http\Request;


class LokasiAlatController extends Controller
{
    // public function index()
    // {
    //     $lokasiAlat = alat::all(); // Ambil semua lokasi alat
    //     return view('dashboard', compact('lokasiAlat'));
    // }

    // public function show($id)
    // {
    //     $lokasi = alat::findOrFail($id);
    //     return view('lokasi_detail', compact('lokasi'));
    // }

    // public function create()
    // {
    //     return view('tambah_lokasi');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama_lokasi' => 'required',
    //         'id_mesin' => 'required|unique:lokasi_alat',
    //         'ip_addres' => 'required|ip',
    //     ]);

    //     alat::create($request->all());

    //     return redirect()->route('dashboard')->with('success', 'Lokasi alat berhasil ditambahkan');
    // }
}
