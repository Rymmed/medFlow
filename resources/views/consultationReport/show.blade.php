@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h4>Consultation Report Details</h4>
        <p><strong>Visit Type:</strong> {{ $report->visit_type }}</p>
        <p><strong>Date:</strong> {{ $report->created_at->format('d M, Y') }}</p>
        <p><strong>Doctor:</strong>{!! auth()->user()->id === $report->doctor_id
                            ? 'Moi'
                            : 'Dr. ' . $report->doctor->lastName . ' ' . $report->doctor->firstName
                        !!}</p>
        <p><strong>Symptoms:</strong> {{ $report->symptoms }}</p>
        <p><strong>Diagnostic Hypotheses:</strong> {{ $report->diagnostic_hypotheses }}</p>
        <p><strong>Final Diagnosis:</strong> {{ $report->final_diagnosis }}</p>
        <a href="{{ route('consultationReport.index', ['patient_id' => $appointment->patient_id]) }}" class="btn btn-secondary">Back to Reports</a>
        @if(auth()->user()->id === $report->doctor_id)
            <a href="{{ route('consultationReport.edit', ['consultationReport' => $report->id]) }}" class="btn btn-secondary">Modifier</a>
            <a href="{{ route('consultationReport.destroy', ['consultationReport' => $report->id]) }}" class="btn btn-secondary">Supprimer</a>
        @endif
    </div>
@endsection
