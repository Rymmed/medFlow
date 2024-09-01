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
                        <div class="card-header pb-0">
                            <div class="d-flex flex-row justify-content-between">
                                <div>
                                    <h5 class="mb-0">Rendez-Vous</h5>
                                </div>
                                <button class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalMessage">
                                    <i class="far fa-calendar-plus me-1"></i> Nouveau Rendez-Vous
                                </button>


                                <div class="modal fade" id="exampleModalMessage" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel">{{ __('Trouver un médecin') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                    <span class="text-dark" aria-hidden="true"><i
                                                            class="fa fa-close"></i></span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form role="form" action="{{ route('search_doctors') }}"
                                                      method="POST">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <select id="speciality" name="speciality[]"
                                                                class="form-control"
                                                                aria-label="speciality" multiple>
                                                            @foreach(config('specialities') as $speciality)
                                                                <option
                                                                    value="{{ $speciality }}">{{ $speciality }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group mb-3 col-6">
                                                            <input type="text" id="city" name="city"
                                                                   class="form-control" aria-label="city"
                                                                   placeholder="Ville">
                                                        </div>
                                                        <div class="form-group mb-3 col-6">
                                                            <input type="text" id="country" name="country"
                                                                   class="form-control" aria-label="country"
                                                                   placeholder="Pays">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit"
                                                                class="btn bg-gradient-primary">{{ __('Rechercher') }}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <x-patient-record.appointments-list :appointments="$appointments"
                                                            :upcomingAppointments="$upcomingAppointments"
                                                            :recentAppointments="$recentAppointments"></x-patient-record.appointments-list>
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
