<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Hospital;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with('hospital');

        if ($request->has('hospital_id') && $request->hospital_id != '') {
            $query->where('hospital_id', $request->hospital_id);
        }

        $patients = $query->get();
        $hospitals = Hospital::orderBy('name')->get();

        if ($request->ajax()) {
            return response()->json($patients);
        }

        return view('pages.user.patient', compact('patients', 'hospitals'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'alamat'      => 'required|string',
            'telepon'     => 'required|string|max:20|unique:patient,telp',
            'hospital_id' => 'required|exists:hospital,id',
        ]);

        Patient::create([
            'name'        => $data['nama'],
            'address'     => $data['alamat'],
            'telp'        => $data['telepon'],
            'hospital_id' => $data['hospital_id'],
        ]);

        return redirect()->route('patients.index');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama'        => 'required|string|max:255',
            'alamat'      => 'required|string',
            'telepon'     => 'required|string|max:20|unique:patient,telp',
            'hospital_id' => 'required|exists:hospital,id',
        ]);

        $patient = Patient::findOrFail($id);
        $patient->update([
            'name'        => $data['nama'],
            'address'     => $data['alamat'],
            'telp'        => $data['telepon'],
            'hospital_id' => $data['hospital_id'],
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return response()->json(['success' => true]);
    }
}
