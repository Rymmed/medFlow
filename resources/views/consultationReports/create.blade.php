@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h1>Create Consultation Report</h1>
        <form action="{{ route('consultationReport.store', $appointment->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="visit_type">Visit Type</label>
                <input type="text" id="visit_type" name="visit_type" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="symptoms">Symptoms</label>
                <textarea id="symptoms" name="symptoms" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="diagnostic_hypotheses">Diagnostic Hypotheses</label>
                <textarea id="diagnostic_hypotheses" name="diagnostic_hypotheses" class="form-control" required></textarea>
            </div>
            <div class="form-group">
                <label for="final_diagnosis">Final Diagnosis</label>
                <textarea id="final_diagnosis" name="final_diagnosis" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Report</button>
        </form>
    </div>
@endsection
