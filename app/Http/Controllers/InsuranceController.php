<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\MedicalRecord;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, $medicalRecord_id): RedirectResponse
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $patient = $medicalRecord->patient;

        $this->authorize('create', [Insurance::class, $patient]);
        $request->validate([
            'type' => 'required|string',
            'number' => 'required|string'
        ]);

        Insurance::create([
            'medicalRecord_id' => $medicalRecord_id,
            'type' => $request->type,
            'number' => $request->number,
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, $insurance_id): RedirectResponse
    {
        $insurance = Insurance::findOrFail($insurance_id);
        $this->authorize('update', $insurance);

        $request->validate([
            'type' => 'required|string',
            'number' => 'required|string'
        ]);

        $insurance->type = $request->type;
        $insurance->number = $request->number;
        $insurance->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($insurance_id)
    {
        $insurance = Insurance::findOrFail($insurance_id);
        $this->authorize('delete', $insurance);

        $insurance->delete();

        return redirect()->back();
    }
}
