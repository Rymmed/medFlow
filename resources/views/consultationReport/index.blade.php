@extends('layouts.user_type.auth')

@section('content')
    <div class="card">
        <x-patient-record.full-consultations-reports
            :consultationReports="$consultationReports" :patient="$patient"></x-patient-record.full-consultations-reports>
    </div>
@endsection
