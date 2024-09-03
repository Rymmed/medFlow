@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Vital Signs -->
            <div class="col-md-12">
                <x-patient-record.vital-signs :medicalRecord="$medicalRecord"></x-patient-record.vital-signs>
            </div>
        </div>
        <div class="row mt-4">
            <!-- Personal & Medical Info, Vaccinations -->
            <div class="col-md-3 text-center">
                <x-patient-record.profile-card :user="auth()->user()"></x-patient-record.profile-card>
                <x-patient-record.medical-info :medicalRecord="$medicalRecord"
                                               :insurance="$medicalRecord->insurance"></x-patient-record.medical-info>
                <x-patient-record.patient-doctors :doctors="auth()->user()->doctors"></x-patient-record.patient-doctors>
                <x-patient-record.vaccinations
                    :vaccinations="$medicalRecord->vaccinations"></x-patient-record.vaccinations>
            </div>

            <!-- Main Content: Appointments, Consultation Reports, Prescriptions -->
            <div class="col-md-9">
                <div class="row">
                    <!-- Appointments -->
                    <div class="col-md-12 card">
                        <x-patient-record.table-header :title="'Rendez-Vous'"></x-patient-record.table-header>
                        <x-patient-record.appointments-list :appointments="$appointments"
                                                            :upcomingAppointments="$upcomingAppointments"
                                                            :oldAppointments="$oldAppointments"></x-patient-record.appointments-list>
                    </div>
                </div>
                <div class="row mt-4">
                    <!-- Consultation Reports -->
                    <x-patient-record.consultation-report
                        :consultationReports="$consultationReports"></x-patient-record.consultation-report>
                </div>
                <!-- Exam Results -->
                <div class="row mt-4">
                    <x-patient-record.exams-results-table
                        :examResults="$medicalRecord->examResults"></x-patient-record.exams-results-table>
                </div>
                <!-- Prescriptions -->
                <div class="row mt-4">
                    <x-patient-record.prescriptions :prescriptions="$prescriptions"></x-patient-record.prescriptions>
                </div>

            </div>
        </div>
    </div>

    <script>
        function toggleIcon(id) {
            var chevronUpIcon = document.getElementById(id + "UpIcon");
            var chevronDownIcon = document.getElementById(id + "DownIcon");

            if (chevronUpIcon.style.display === "none") {
                chevronUpIcon.style.display = "inline";
                chevronDownIcon.style.display = "none";
            } else {
                chevronUpIcon.style.display = "none";
                chevronDownIcon.style.display = "inline";
            }
        }
    </script>
@endsection
