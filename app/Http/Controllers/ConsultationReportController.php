<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index($patient_id)
    {
        $patient = User::findOrFail($patient_id);
        $this->authorize('viewAny', [ConsultationReport::class, $patient]);

        $consultationReports = ConsultationReport::whereHas('appointment', function ($query) use ($patient) {
            $query->where('patient_id', $patient->id);
        })->paginate(10);

        return view('consultationReports.index', compact('consultationReports', 'patient'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $patient = $appointment->patient;

        $this->authorize('create', [ConsultationReport::class, $patient->id]);

        return view('consultationReports.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, $appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $patient = $appointment->patient;

        $this->authorize('create', [ConsultationReport::class, $patient->id]);
        $request->validate([
            'visit_type' => 'required|string',
            'symptoms' => 'nullable|string',
            'diagnostic_hypotheses' => 'nullable|string',
            'final_diagnosis' => 'required|string',
        ]);
        ConsultationReport::create([
            'appointment_id' => $appointment_id,
            'doctor_id' => Auth::id(),
            'visit_type' => $request->visit_type,
            'symptoms' => $request->symptoms,
            'diagnostic_hypotheses' => $request->diagnostic_hypotheses,
            'final_diagnosis' => $request->final_diagnosis,
        ]);

        return redirect()->route('consultationReports.index', $patient->id)->with('success', 'Rapport de consultation ajouté avec succès.');
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $appointment = Appointment::findOrFail($consultationReport->appointment_id);
        $this->authorize('view' , $consultationReport);

        return view('consultationReports.show', compact('consultationReport', 'appointment'));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $this->authorize('update', $consultationReport);

        return view('consultationReports.edit', compact('consultationReport'));
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, $id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $this->authorize('update', $consultationReport);
        $request->validate([
            'visit_type' => 'required|string',
            'symptoms' => 'nullable|string',
            'diagnostic_hypotheses' => 'nullable|string',
            'final_diagnosis' => 'required|string',
        ]);

        $consultationReport->update($request->only(['visit_type', 'symptoms', 'diagnostic_hypotheses', 'final_diagnosis']));

        return redirect()->route('consultationReports.index', $consultationReport->appointment->patient_id)->with('success', 'Rapport de consultation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $this->authorize('delete', $consultationReport);

        $consultationReport->delete();

        return redirect()->route('consultationReports.index', $consultationReport->appointment->patient_id)->with('success', 'Rapport de consultation supprimé avec succès.');
    }
}
