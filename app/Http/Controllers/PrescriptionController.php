<?php

namespace App\Http\Controllers;

use App\Models\ConsultationReport;
use App\Models\MedicalRecord;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the prescriptions.
     *
     * @param $record_id
     * @return View
     * @throws AuthorizationException
     */
    public function index($record_id): View
    {
        $record = MedicalRecord::findOrFail($record_id);
        $patient = $record->patient;

        // Authorize the viewAny action
        $this->authorize('viewAny', [Prescription::class, $patient]);

        $prescriptions = Prescription::whereHas('medicalRecord', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();

        return view('prescriptions.index', compact('prescriptions', 'patient', 'record'));
    }

    /**
     * Display the specified prescription.
     *
     * @param $prescription_id
     * @return View
     * @throws AuthorizationException
     */
    public function show($prescription_id): View
    {
        $prescription = Prescription::findOrFail($prescription_id);
        // Authorize the view action
        $this->authorize('view', $prescription);

        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for creating a new prescription.
     *
     * @param int $report_id
     * @return View
     * @throws AuthorizationException
     */
    public function create(int $report_id, $record_id): View
    {
        $report = ConsultationReport::findOrFail($report_id);
        $this->authorize('create', [Prescription::class, $report_id]);

        // Pas de prescription existante, donc on passe `null`
        $prescription = null;

        return view('prescriptions.form', compact('report', 'record_id', 'prescription'));
    }


    /**
     * Store a newly created prescription in storage.
     *
     * @param Request $request
     * @param $report_id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(Request $request, $report_id): JsonResponse
    {
        $report = ConsultationReport::findOrFail($report_id);
        $this->authorize('create', [Prescription::class, $report_id]);

        $validatedData = $request->validate([
            'treatment' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $record_id = $report->appointment->patient->medicalRecord->id;

        $prescription = Prescription::create([
            'consultation_report_id' => $report_id,
            'medicalRecord_id' => $record_id,
            'treatment' => $request->treatment,
            'description' => $request->description
        ]);

        return response()->json(['success' => true, 'prescription_id' => $prescription->id]);
    }

    /**
     * Show the form for editing the specified prescription.
     *
     * @param $prescription_id
     * @return View
     * @throws AuthorizationException
     */
    public function edit($prescription_id): View
    {
        $prescription = Prescription::findOrFail($prescription_id);
        $this->authorize('update', $prescription);

        // Récupérer les informations associées au rapport de consultation
        $report = $prescription->consultationReport;
        $record_id = $report->appointment->patient->medicalRecord->id;

        return view('prescriptions.form', compact('report', 'record_id', 'prescription'));
    }

    /**
     * Update the specified prescription in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $prescription = Prescription::findOrFail($id);
        // Authorize the update action
        $this->authorize('update', $prescription);

        $validatedData = $request->validate([
            'treatment' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $prescription->update($validatedData);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified prescription from storage.
     *
     * @param $id
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy($id): RedirectResponse
    {
        $prescription = Prescription::findOrFail($id);
        // Authorize the delete action
        $this->authorize('delete', $prescription);

        $prescription->delete();

        return redirect()->back();
    }
}
