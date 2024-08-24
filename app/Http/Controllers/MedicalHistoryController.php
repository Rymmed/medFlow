<?php

namespace App\Http\Controllers;

use App\Models\MedicalHistory;
use App\Models\MedicalRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, $medicalRecord_id): RedirectResponse
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

        return redirect()->back();
    }


    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, $medicalHistory_id): RedirectResponse
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

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy($medicalHistory_id): RedirectResponse
    {
        $medicalHistory = MedicalHistory::findOrFail($medicalHistory_id);
        $this->authorize('delete', $medicalHistory);
        $medicalHistory->delete();

        return redirect()->back();
    }
}
