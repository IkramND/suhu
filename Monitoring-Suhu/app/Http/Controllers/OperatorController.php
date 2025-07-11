<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Alat;

class OperatorController extends Controller
{
    public function list()
    {
        $operators = User::whereHas('role', function ($query) {
            $query->where('role', 'operator');
        })->get();
        return view('operator.operatorlist', compact('operators'));
    }

    function edit($id)
    {
        $operators = User::findOrFail($id);
        $alats = Alat::all();
        return view('operator.edit', compact('operators', 'alats'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'acess' => 'required'
        ]);

        $operators = User::findOrFail($id);
        $operators->update($request->all());

        return redirect()->route('operator.list')->with('success', 'success');
    }

    public function destroy($id)
    {
        $configuration = User::findOrFail($id);
        $configuration->delete();
        return redirect()->route('configuration.list')->with('success', 'success');
    }
}
