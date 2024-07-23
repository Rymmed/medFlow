@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Personal infos --->
            <div class="col-md-3 card text-center">
                <x-patient-record.profile-card></x-patient-record.profile-card>
                <x-patient-record.medical-info :medicalRecord="$medicalRecord"
                                               :insuranceDetails="$insuranceDetails"></x-patient-record.medical-info>
                <x-patient-record.medical-histories :medicalHistories="$medicalHistories"></x-patient-record.medical-histories>
                <x-patient-record.vaccinations :vaccinations="$vaccinations"></x-patient-record.vaccinations>
            </div>
            <div class="col-md-9">
                <div>
                    <x-patient-record.vital-signs :vital_signs="$vital_signs"></x-patient-record.vital-signs>
                </div>
                <div class="row mt-4">
                    <div class="col-md-7">
                        <x-patient-record.consultation-report
                            :consultationReports="$consultationReports"></x-patient-record.consultation-report>
                    </div>
                    <div class="col-md-5 card">
                        <x-patient-record.prescriptions :prescriptions="$prescriptions"></x-patient-record.prescriptions>
                    </div>
                </div>
                <div class="row card mt-4 ms-1">
                    <div class="card-header pb-0">
                        <div class="d-flex flex-row justify-content-between">
                            <div>
                                <h5 class="mb-0">Rendez-Vous</h5>
                            </div>
                            <button class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button" data-bs-toggle="modal"
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
                                                        <input type="text" id="town" name="town"
                                                               class="form-control" aria-label="town"
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
                                <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
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
                <div>
                    <x-patient-record.exams-results :examResults="$examResults"></x-patient-record.exams-results>
                </div>
                <div>

                </div>
            </div>
        </div>
    </div>


    <!-- Personal and Medical Record Information -->
    {{--        <div class="row">--}}
    {{--            <div class="col-md-7 card">--}}
    {{--                <div class="row">--}}
    {{--                    <!-- Left Section -->--}}
    {{--                    <div class="col-md-4 text-center mt-4">--}}
    {{--                        <div class="position-relative">--}}
    {{--                            <x-profile-image--}}
    {{--                                :class="'avatar avatar-xl border-radius-section shadow-sm'"></x-profile-image>--}}
    {{--                            <x-edit-image-btn></x-edit-image-btn>--}}
    {{--                        </div>--}}
    {{--                        <h6 class="font-weight-bolder card-title mt-3">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>--}}
    {{--                        <p class="text-secondary text-sm">{{ auth()->user()->email }}</p>--}}
    {{--                        <h6 class="text-sm">Rendez-Vous</h6>--}}
    {{--                        <div class="row justify-content-center">--}}
    {{--                            <div class="col-5 mt-2">--}}
    {{--                                <h4>5</h4>--}}
    {{--                                <p class="text-sm text-secondary">passé</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-1">--}}
    {{--                                <div class="border-start h-100"></div>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-5 mt-2">--}}
    {{--                                <h4>2</h4>--}}
    {{--                                <p class="text-sm text-secondary">à venir</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}

    {{--                    <!-- Separator -->--}}
    {{--                    <div class="col-md-1 d-flex align-items-center justify-content-center">--}}
    {{--                        <div class="border-start-sm h-100"></div>--}}
    {{--                    </div>--}}

    {{--                    <!-- Right Section -->--}}
    {{--                    <div class="col-md-7 mt-4">--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Sexe') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">--}}
    {{--                                    @if(auth()->user()->gender === 0)--}}
    {{--                                        {{ __('Homme') }}--}}
    {{--                                    @else--}}
    {{--                                        {{ __('Femme') }}--}}
    {{--                                    @endif--}}
    {{--                                </p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Age') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ \Carbon\Carbon::parse(auth()->user()->dob)->age }} {{ __('ans') }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Taille') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->height }}</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Poids') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->weight }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Adresse') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ auth()->user()->address }}</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Ville') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ auth()->user()->city }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Groupe Sanguin') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->blood_group }}</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Zone') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->area }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Tabagisme') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->smoking ? 'Oui' : 'Non' }}</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Alcool') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->alcohol ? 'Oui' : 'Non' }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                        <div class="row mx-0 w-100">--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Activité Physique') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->sedentary_lifestyle ? 'Non' : 'Oui' }}</p>--}}
    {{--                            </div>--}}
    {{--                            <div class="col-6">--}}
    {{--                                <p class="text-sm text-secondary text-bold">{{ __('Assurance') }}</p>--}}
    {{--                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $insuranceDetails ? $insuranceDetails->type . '-' . $insuranceDetails->number : 'Pas d\'assurance' }}</p>--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--            <!-- Consultation Reports -->--}}
    {{--            <div class="col-md-4">--}}
    {{--                <div class="accordion-item mt-2">--}}
    {{--                    <div class="card">--}}
    {{--                        <h6 class="mb-0 accordion-header" id="headingReports">--}}
    {{--                            <a class="accordion-button" type="button" data-bs-toggle="collapse"--}}
    {{--                               data-bs-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports"--}}
    {{--                               onclick="toggleIcon('reports')">--}}
    {{--                                <span>{{ __('Rapports de Consultation') }}</span>--}}
    {{--                                <x-toggle-icon-component id="reports"/>--}}
    {{--                            </a>--}}
    {{--                        </h6>--}}
    {{--                        <div id="collapseReports" class="accordion-collapse collapse show"--}}
    {{--                             aria-labelledby="headingReports">--}}
    {{--                            <div class="card-body">--}}
    {{--                                @foreach($consultation_reports as $report)--}}
    {{--                                    <p>{{ $report->date }}: {{ $report->final_diagnosis }}</p>--}}
    {{--                                @endforeach--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--                <div class="accordion-item mt-2">--}}
    {{--                    <div class="card">--}}
    {{--                        <h6 class="mb-0 accordion-header" id="headingMedicalHistory">--}}
    {{--                            <a class="accordion-button" type="button" data-bs-toggle="collapse"--}}
    {{--                               data-bs-target="#collapseMedicalHistory" aria-expanded="true"--}}
    {{--                               aria-controls="collapseMedicalHistory" onclick="toggleIcon('medicalHistory')">--}}
    {{--                                <span>{{ __('Antécédents Médicaux') }}</span>--}}
    {{--                                <x-toggle-icon-component id="medicalHistory"/>--}}
    {{--                            </a>--}}
    {{--                        </h6>--}}
    {{--                        <div id="collapseMedicalHistory" class="accordion-collapse collapse show"--}}
    {{--                             aria-labelledby="headingMedicalHistory">--}}
    {{--                            <div class="card-body">--}}
    {{--                                @if($medicalHistories)--}}
    {{--                                    @foreach($medicalHistories as $history)--}}
    {{--                                        <p>{{ $history->title }}: {{ $history->description }}</p>--}}
    {{--                                    @endforeach--}}
    {{--                                @else--}}
    {{--                                    <p>Pas d'antécédents remplis.</p>--}}
    {{--                                @endif--}}
    {{--                            </div>--}}
    {{--                        </div>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}


    <!-- Accordion Sections -->


@endsection
