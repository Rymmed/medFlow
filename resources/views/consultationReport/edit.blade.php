@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1>Edit Consultation Report</h1>
        <form action="{{ route('consultationReport.update', $consultationReport->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="visit_type">Type de visite</label>
                <input type="text" id="visit_type" name="visit_type" class="form-control" value="{{ $consultationReport->visit_type }}" required>
            </div>
            <div class="form-group">
                <label for="symptoms">Symptômes</label>
                <textarea id="symptoms" name="symptoms" class="form-control">{{ $consultationReport->symptoms }}</textarea>
            </div>
            <div class="form-group">
                <label for="diagnostic_hypotheses">Hypothèses diagnostiques</label>
                <textarea id="diagnostic_hypotheses" name="diagnostic_hypotheses" class="form-control">{{ $consultationReport->diagnostic_hypotheses }}</textarea>
            </div>
            <div class="form-group">
                <label for="final_diagnosis">Diagnostic final</label>
                <textarea id="final_diagnosis" name="final_diagnosis" class="form-control" required>{{ $consultationReport->final_diagnosis }}</textarea>
            </div>
            <div class="justify-content-between">
                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('myPatient.record', ['patient_id' => $consultationReport->appointment->patient_id]) }}" class="btn btn-secondary">Retour au dossier</a>
            </div>
        </form>
    </div>
@endsection
