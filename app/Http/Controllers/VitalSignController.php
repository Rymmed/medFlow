<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\VitalSign;


class VitalSignController extends Controller
{
    public function index($patient_id)
    {
        $this->authorize('viewAny', [VitalSign::class, $patient_id]);

        $patient = User::findOrFail($patient_id);
        $vitalSigns = VitalSign::whereHas('medical_record', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();

        return view('vital_signs.index', compact('vitalSigns', 'patient'));
    }

    public function create($patient_id)
    {
        $this->authorize('create', [VitalSign::class, $patient_id]);

        return view('vital_signs.create', compact('patient_id'));
    }

    public function store(Request $request, $patient_id)
    {
        $this->authorize('create', [VitalSign::class, $patient_id]);

        $request->validate([
            'type' => 'required|string|max:255',
            'value' => 'required|numeric',
            'unit' => 'required|string'
        ]);

        $medicalRecord = MedicalRecord::where('patient_id', $patient_id)->firstOrFail();
        VitalSign::create([
            'medical_record_id' => $medicalRecord->id,
            'type' => $request->type,
            'value' => $request->value,
            'unit' => $request->unit
        ]);

        return redirect()->route('vital_signs.index', $patient_id)->with('success', 'Signe vital ajouté avec succès.');
    }

    public function show(VitalSign $vitalSign)
    {
        $this->authorize('view', $vitalSign);

        return view('vital_signs.show', compact('vitalSign'));
    }

    public function edit(VitalSign $vitalSign)
    {
        $this->authorize('update', $vitalSign);

        return view('vital_signs.edit', compact('vitalSign'));
    }

    public function update(Request $request, VitalSign $vitalSign)
    {
        $this->authorize('update', $vitalSign);

        $request->validate([
            'type' => 'required|string|max:255',
            'value' => 'required|numeric',
            'unit' => 'required|string'
        ]);

        $vitalSign->update([
            'type' => $request->type,
            'value' => $request->value,
            'unit' => $request->unit
        ]);

        return redirect()->route('vital_signs.index', $vitalSign->medicalRecord->patient_id)->with('success', 'Signe vital mis à jour avec succès.');
    }

    public function destroy(VitalSign $vitalSign)
    {
        $this->authorize('delete', $vitalSign);

        $vitalSign->delete();

        return redirect()->route('vital_signs.index', $vitalSign->medicalRecord->patient_id)->with('success', 'Signe vital supprimé avec succès.');
    }
}
