@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Appointments -->
            <div class="col-md-12 card">
                <x-patient-record.table-header :title="'Rendez-Vous'"></x-patient-record.table-header>
                <x-patient-record.appointments-list :appointments="$appointments"
                                                    :upcomingAppointments="$upcomingAppointments"
                                                    :oldAppointments="$oldAppointments"></x-patient-record.appointments-list>
            </div>
        </div>
    </div>
@endsection
