<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Vaccination;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\View\View;

class VaccinationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, $medicalRecord_id): RedirectResponse
    {
        $medicalRecord = MedicalRecord::findOrFail($medicalRecord_id);
        $this->authorize('create', [Vaccination::class, $medicalRecord]);
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
        ]);

        Vaccination::create([
            'medicalRecord_id' => $medicalRecord_id,
            'title' => $request->title,
            'date' => $request->date,
        ]);

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, $vaccination_id): JsonResponse
    {
        $vaccination = Vaccination::findOrFail($vaccination_id);
        $this->authorize('update', $vaccination);
        $request->validate([
            'title' => 'required|string|max:255',
            'date' => 'nullable|date',
        ]);

        $vaccination->title = $request->title;
        $vaccination->date = $request->date;
        $vaccination->save();
        return response()->json(['success' => true, 'vaccination' => $vaccination]);
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy($vaccination_id): RedirectResponse
    {
        $vaccination = Vaccination::findOrFail($vaccination_id);
        $this->authorize('delete', $vaccination);
        $vaccination->delete();

        return redirect()->back();
    }
}
