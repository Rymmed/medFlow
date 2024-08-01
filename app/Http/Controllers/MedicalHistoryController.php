<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
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
    public function store(Request $request, $medicalRecord_id)
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $patient = $medicalRecord->patient;

        $this->authorize('create', [MedicalHistory::class, $patient]);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        MedicalHistory::create([
            'medicalRecord_id' => $medicalRecord_id,
            'title' => $request->title,
            'type' => $request->type,
            'subtype' => $request->subtype,
            'description' => $request->description
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalHistory $medicalHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalHistory $medicalHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $medicalHistory_id)
    {
        $medicalHistory = MedicalHistory::findOrFail($medicalHistory_id);

        $this->authorize('update', $medicalHistory);

        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string'
        ]);

        $medicalHistory->update([
            'title' => $request->title,
            'type' => $request->type,
            'subtype' => $request->subtype,
            'description' => $request->description
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalHistory $medicalHistory)
    {
        //
    }
}
