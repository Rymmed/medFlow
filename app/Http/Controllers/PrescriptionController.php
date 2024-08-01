<?php

namespace App\Http\Controllers;

use App\Models\ConsultationReport;
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
     * @param int $patient_id
     * @return View
     * @throws AuthorizationException
     */
    public function index($report_id): View
    {
        $report = ConsultationReport::findOrFail($report_id);
        $patient = $report->appointment->patient;

        // Authorize the viewAny action
        $this->authorize('viewAny', [Prescription::class, $patient]);

        $prescriptions = Prescription::whereHas('consultationReport.appointment', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->get();

        return view('prescriptions.index', compact('prescriptions', 'patient', 'report'));
    }

    /**
     * Display the specified prescription.
     *
     * @param Prescription $prescription
     * @return View
     * @throws AuthorizationException
     */
    public function show(Prescription $prescription): View
    {
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
    public function create(int $report_id): View
    {
        $report = ConsultationReport::findOrFail($report_id);
        $this->authorize('create', [Prescription::class, $report_id]);

        return view('prescriptions.create', compact('report'));
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

        $prescription = Prescription::create([
            'consultation_report_id' => $report_id,
            'treatment' => $request->treatment,
            'description' => $request->description
        ]);

        return response()->json(['success' => true, 'prescription_id' => $prescription->id]);
    }

    /**
     * Show the form for editing the specified prescription.
     *
     * @param Prescription $prescription
     * @return View
     * @throws AuthorizationException
     */
    public function edit($id): View
    {
        $prescription = Prescription::findOrFail($id);
        // Authorize the update action
        $this->authorize('update', $prescription);

        return view('prescriptions.edit', compact('prescription'));
    }

    /**
     * Update the specified prescription in storage.
     *
     * @param Request $request
     * @param Prescription $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Prescription $id): JsonResponse
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

        return redirect()->route('prescriptions.index', $prescription->consultationReport->appointment->patient_id)
            ->with('success', 'Prescription deleted successfully.');
    }
}
