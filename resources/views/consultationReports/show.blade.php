@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h4>Consultation Report Details</h4>
        <p><strong>Visit Type:</strong> {{ $consultationReport->visit_type }}</p>
        <p><strong>Date:</strong> {{ $consultationReport->created_at->format('d M, Y') }}</p>
        <p><strong>Doctor:</strong>{!! auth()->user()->id === $consultationReport->doctor_id
                            ? 'Moi'
                            : 'Dr. ' . $consultationReport->doctor->lastName . ' ' . $consultationReport->doctor->firstName
                        !!}</p>
        <p><strong>Symptoms:</strong> {{ $consultationReport->symptoms }}</p>
        <p><strong>Diagnostic Hypotheses:</strong> {{ $consultationReport->diagnostic_hypotheses }}</p>
        <p><strong>Final Diagnosis:</strong> {{ $consultationReport->final_diagnosis }}</p>
        <a href="{{ route('consultationReports.index', ['patient_id' => $appointment->patient_id]) }}" class="btn btn-secondary">Back to Reports</a>
        <a href="{{ route('consultationReport.edit', ['consultationReport' => $consultationReport->id]) }}" class="btn btn-secondary">Modifier</a>
        <a href="{{ route('consultationReport.destroy', ['consultationReport' => $consultationReport->id]) }}" class="btn btn-secondary">Supprimer</a>
    </div>
@endsection
