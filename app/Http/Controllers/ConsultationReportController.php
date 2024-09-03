<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\ConsultationReport;
use App\Models\Prescription;
use App\Models\PrescriptionLine;
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

        return view('consultationReport.index', compact('consultationReports', 'patient'));
    }

    /**
     * Show the form for creating a new resource.
     * @throws AuthorizationException
     */
    public function create($appointment_id)
    {
        $appointment = Appointment::findOrFail($appointment_id);
        $patient = $appointment->patient;
        $appointment->status = AppointmentStatus::STARTED;
        $appointment->save();
        $this->authorize('create', [ConsultationReport::class, $patient->id]);

        return view('consultationReport.create', compact('appointment'));
    }

    /**
     * Store a newly created resource in storage.
     * @throws AuthorizationException
     */
    public function store(Request $request, $appointmentId)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $patient = $appointment->patient;
        $record_id = $patient->medicalRecord->id;

        $this->authorize('create', [ConsultationReport::class, $patient->id]);
        $existingReport = ConsultationReport::where('appointment_id', $appointmentId)->first();

        if ($existingReport) {
            return response()->json(['success' => false, 'message' => 'Un rapport de consultation existe déjà pour ce rendez-vous.']);
        }
        $report = ConsultationReport::create([
            'appointment_id' => $appointmentId,
            'doctor_id' => Auth::id(),
            'visit_type' => $request->visit_type,
            'symptoms' => $request->symptoms,
            'diagnostic_hypotheses' => $request->diagnostic_hypotheses,
            'final_diagnosis' => $request->final_diagnosis,
        ]);

        if ($request->filled('treatment') || $request->filled('description')) {
            $prescription = Prescription::create([
                'consultation_report_id' => $report->id,
                'medicalRecord_id' => $record_id,
                'treatment' => $request->treatment,
                'description' => $request->description,
            ]);

            if ($request->filled('prescription_lines')) {
                $lines = json_decode($request->prescription_lines, true);
                foreach ($lines as $line) {
                    PrescriptionLine::create([
                        'prescription_id' => $prescription->id,
                        'name' => $line['name'],
                        'dose' => $line['dose'],
                        'duration' => $line['duration'],
                    ]);
                }
            }
        }
        $appointment->status = AppointmentStatus::COMPLETED;
        $appointment->save();
        return response()->json(['success' => true, 'report_id' => $report->id]);
    }

    /**
     * Display the specified resource.
     * @throws AuthorizationException
     */
    public function show($id)
    {
        $report = ConsultationReport::findOrFail($id);
        $appointment = Appointment::findOrFail($report->appointment_id);
        $this->authorize('view' , $report);
        if ($report->prescription)
        {
            $this->authorize('view', $report->prescription);
        }
        return view('consultationReport.show', compact('report', 'appointment'));
    }

    /**
     * @throws AuthorizationException
     */
    public function edit($id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $this->authorize('update', $consultationReport);

        return view('consultationReport.edit', compact('consultationReport'));
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

        return redirect()->route('consultationReport.show', $consultationReport->id)->with('success', 'Rapport de consultation mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy($id)
    {
        $consultationReport = ConsultationReport::findOrFail($id);
        $this->authorize('delete', $consultationReport);

        $patient_id = $consultationReport->appointment->patient->id;
        $consultationReport->delete();

        return redirect()->route('myPatient.record', ['patient_id' => $patient_id]);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $patient_id = auth()->user()->id;

        $consultationReports = ConsultationReport::whereHas('appointment', function ($queryBuilder) use ($patient_id) {
            $queryBuilder->where('patient_id', $patient_id);
        })
            ->where(function($q) use ($query) {
                $q->where('visit_type', 'LIKE', "%{$query}%");
            })
            ->with('prescription.prescriptionLines')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($consultationReports);
    }

}
