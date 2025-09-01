<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
        $hospitals = Hospital::all();
        return view('pages.user.hospital', compact('hospitals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'email'   => 'nullable|email|unique:hospital,email',
            'telp'    => 'nullable|string|max:20|unique:hospital,telp',
        ]);

        Hospital::create($data);

        return redirect()->route('hospitals.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'address' => 'required|string',
            'email'   => 'nullable|email|unique:hospital,email',
            'telp'    => 'nullable|string|max:20|unique:hospital,telp',
        ]);

        $hospital = Hospital::findOrFail($id);
        $hospital->update($data);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->delete();

        return response()->json(['success' => true]);
    }
}
