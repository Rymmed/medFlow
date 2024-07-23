@extends('layouts.user_type.auth')

@section('content')
    <div class="card">
        <x-patient-record.full-consultations-records
            :consultationReports="$consultationReports" :patient="$patient"></x-patient-record.full-consultations-records>
    </div>
@endsection
