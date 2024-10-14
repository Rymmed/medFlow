@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="card shadow-lg">
            <div class="bg-transparent-blue border-radius-xl ">
                <h4 class="m-3 text-white">Rapport de consultation</h4>
            </div>
            <div class="card-body">
                <!-- Détails du rapport de consultation -->
                <div class="mb-3">
                    <strong>Type de visite:</strong>
                    <span class="text-muted">{{ $report->visit_type }}</span>
                </div>
                <div class="mb-3">
                    <strong>Date de création:</strong>
                    <span class="text-muted">{{ $report->created_at->format('d M, Y') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Date de modification:</strong>
                    <span class="text-muted">{{ $report->updated_at->format('d M, Y') }}</span>
                </div>
                <div class="mb-3">
                    <strong>Médecin:</strong>
                    <span
                        class="text-muted">{!! auth()->user()->id === $report->doctor_id ? 'Moi' : 'Dr. ' . $report->doctor->lastName . ' ' . $report->doctor->firstName !!}</span>
                </div>
                <div class="mb-3">
                    <strong>Symptômes:</strong>
                    <span class="text-muted">{{ $report->symptoms }}</span>
                </div>
                <div class="mb-3">
                    <strong>Hypothèses diagnostiques:</strong>
                    <span class="text-muted">{{ $report->diagnostic_hypotheses }}</span>
                </div>
                <div class="mb-3">
                    <strong>Diagnostic final:</strong>
                    <span class="text-muted">{{ $report->final_diagnosis }}</span>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('myPatient.record', ['patient_id' => $appointment->patient_id]) }}"
                       class="btn bg-gradient-secondary me-2">Retour au dossier</a>
                    @if(auth()->user()->id === $report->doctor_id)
                        <div>
                            <a href="{{ route('consultationReport.edit', ['consultationReport' => $report->id]) }}"
                               class="btn bg-gradient-blue text-white me-2">Modifier</a>
                        </div>
                        <form method="POST"
                              action="{{ route('consultationReport.destroy', ['consultationReport_id' => $report->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn bg-gradient-dark text-white">Supprimer</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @if(auth()->user()->id === $report->doctor_id)
            <div class="card shadow-lg mt-2">
                <div class="card-body">
                    <x-prescription.createOrUpdate :prescription="$report->prescription"
                                                   :report="$report"></x-prescription.createOrUpdate>
                </div>
            </div>
        @else
            @if(!is_null($report->prescription))
                <div class="card shadow-lg mt-2">
                    <div class="card-body">
                        <x-prescription.show :prescription="$report->prescription"></x-prescription.show>
                    </div>
                </div>
            @endif
        @endif
    </div>

@endsection
