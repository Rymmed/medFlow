<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, $medicalRecord_id): JsonResponse
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $this->authorize('update', $medicalRecord);
        $request->validate([
            'height' => 'nullable|numeric',
            'weight' => 'nullable|numeric',
        ]);

        $medicalRecord->update($request->all());

        return response()->json(['success' => true, 'medicalRecord' => $medicalRecord]);
    }

    /**
     * @throws AuthorizationException
     */
    public function updateVitalSigns(Request $request, $medicalRecord_id): JsonResponse
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $this->authorize('update', $medicalRecord);
        $request->validate([
            'temperature' => 'nullable|numeric',
            'heart_rate' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'respiratory_rate' => 'nullable|numeric',
            'oxygen_saturation' => 'nullable|numeric',
        ]);

        $medicalRecord->temperature = $request->temperature;
        $medicalRecord->heart_rate = $request->heart_rate;
        $medicalRecord->blood_pressure= $request->blood_pressure;
        $medicalRecord->respiratory_rate = $request->respiratory_rate;
        $medicalRecord->oxygen_saturation = $request->oxygen_saturation;
        $medicalRecord->save();


        return response()->json(['success' => true, 'medicalRecord' => $medicalRecord]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        //
    }
}
