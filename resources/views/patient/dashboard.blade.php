@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Personal infos --->
            <div class="col-md-3 text-center">
{{--                <x-patient-record.profile-card :user="auth()->user()"></x-patient-record.profile-card>--}}
                <x-patient-record.medical-info :medicalRecord="$medicalRecord"
                                               :insuranceDetails="$medicalRecord->insuranceDetails"></x-patient-record.medical-info>
                <x-patient-record.vaccinations
                    :vaccinations="$medicalRecord->vaccinations"></x-patient-record.vaccinations>
            </div>
            <div class="col-md-9">
                <div>
                    <x-patient-record.vital-signs
                        :vital_signs="$medicalRecord->vital_signs"></x-patient-record.vital-signs>
                </div>
                <div class="row mt-4">
                    <div class="col-md-7">
                        <x-patient-record.consultation-report
                            :consultationReports="$consultationReports"></x-patient-record.consultation-report>
                    </div>
                    <div class="col-md-5">
                        <x-patient-record.prescriptions
                            :prescriptions="$prescriptions"></x-patient-record.prescriptions>
                    </div>
                </div>
                <div class="row card mt-4 ms-1">
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
                    <div class="card-body px-0 pt-0 pb-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                        type="button" role="tab" aria-controls="all" aria-selected="true">Tous
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab"
                                        data-bs-target="#upcoming"
                                        type="button" role="tab" aria-controls="upcoming" aria-selected="false">À venir
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="recent-tab" data-bs-toggle="tab" data-bs-target="#recent"
                                        type="button" role="tab" aria-controls="recent" aria-selected="false">Anciens
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="all" role="tabpanel" aria-labelledby="all-tab">
                                <x-patient-record.appointments-table
                                    :appointments="$appointments"></x-patient-record.appointments-table>
                            </div>
                            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                <x-patient-record.appointments-table
                                    :appointments="$upcomingAppointments"></x-patient-record.appointments-table>
                            </div>
                            <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                                <x-patient-record.appointments-table
                                    :appointments="$recentAppointments"></x-patient-record.appointments-table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-4">

                </div>
                <div>
                    <x-patient-record.exams-results
                        :examResults="$medicalRecord->examResults"></x-patient-record.exams-results>
                </div>
            </div>
        </div>
    </div>
@endsection
