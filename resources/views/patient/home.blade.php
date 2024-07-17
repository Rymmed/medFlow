@extends('layouts.user_type.auth')
@php
    $specialties = config('specialties');
@endphp
@section('content')
    <div class="container-fluid">
        <!-- Informations Personnelles -->
        <div class="row">
            <div class="col-md-7 card">
                <div class="row">
                    <!-- Left Section -->
                    <div class="col-md-4 text-center mt-4">
                        <div class="position-relative">
                            <x-profile-image :class="'avatar avatar-xl border-radius-section shadow-sm'"></x-profile-image>
                            <x-edit-image-btn></x-edit-image-btn>
                        </div>
                        <h6 class="font-weight-bolder card-title mt-3">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>
                        <p class="text-secondary text-sm">
                            {{ auth()->user()->email }}
                        </p>
                        <h6 class="text-sm">
                            Rendez-Vous
                        </h6>
                        <div class="row justify-content-center">
                            <div class="col-5 mt-2">
                                <h4>5</h4>
                                <p class="text-sm text-secondary">passé</p>
                            </div>
                            <div class="col-1">
                                <div class="border-start h-100 "></div>
                            </div>
                            <div class="col-5 mt-2">
                                <h4>2</h4>
                                <p class="text-sm text-secondary">passé</p>
                            </div>
                        </div>
                    </div>

                    <!-- Separator -->
                    <div class="col-md-1 d-flex align-items-center justify-content-center">
                        <div class="border-start-sm h-100"></div>
                    </div>

                    <!-- Right Section -->
                    <div class="col-md-7 mt-4">
                        <div class="row mx-0 w-100">
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Sexe') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">@if(auth()->user()->gender === 0)
                                        {{ __('Homme') }}
                                    @else
                                        {{ __('Femme') }}
                                    @endif</p>
                            </div>
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Age') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ \Carbon\Carbon::parse(auth()->user()->dob)->age }} {{ __('ans') }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Taille') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->height }}</p>
                            </div>
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Poids') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ $medicalRecord->weight }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Adresse') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ auth()->user()->address }}</p>
                            </div>
                            <div class="col-6">
                                <p class="text-sm text-secondary text-bold">{{ __('Ville') }}</p>
                                <p class="border-bottom text-sm pb-2 text-dark text-bold">{{ auth()->user()->city }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--- Liste des Rendez-vous--->
        <div class="row mt-4">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Rendez-Vous</h5>
                        </div>
                        <a href="{{ route('search_doctors') }}" class="btn bg-gradient-primary btn-md mb-0"
                           type="button" data-bs-toggle="modal" data-bs-target="#exampleModalMessage"> <i
                                class="far fa-calendar-plus me-1"></i>
                            Nouveau Rendez-Vous</a>
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
                    <div class="card-body px-0 pt-0 pb-2">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
                                        type="button" role="tab" aria-controls="all" aria-selected="true">Tous
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab"
                                        data-bs-target="#upcoming" type="button" role="tab" aria-controls="upcoming"
                                        aria-selected="false">À venir
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
                                <x-appointments-table :appointments="$appointments"></x-appointments-table>
                            </div>
                            <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
                                <x-appointments-table :appointments="$upcomingAppointments"></x-appointments-table>
                            </div>
                            <div class="tab-pane fade" id="recent" role="tabpanel" aria-labelledby="recent-tab">
                                <x-appointments-table :appointments="$recentAppointments"></x-appointments-table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Allergies -->
{{--        <div class="accordion" id="accordionAllergies">--}}
{{--            <div class="accordion-item">--}}
{{--                <div class="card mt-2">--}}
{{--                    <h6 class="mb-0 accordion-header" id="headingAllergies">--}}
{{--                        <a class="accordion-button" type="button" data-bs-toggle="collapse"--}}
{{--                           data-bs-target="#collapseAllergies" aria-expanded="true"--}}
{{--                           aria-controls="collapseAllergies" onclick="toggleIcon('allergies')">--}}
{{--                            <span>{{ __('Allergies') }}</span>--}}
{{--                            <x-toggle-icon-component id="allergies"/>--}}
{{--                        </a>--}}
{{--                    </h6>--}}
{{--                    <div id="collapseAllergies" class="accordion-collapse collapse show"--}}
{{--                         aria-labelledby="headingAllergies">--}}
{{--                        <div class="card-body">--}}
{{--                            @foreach($allergies as $allergy)--}}
{{--                                <p>{{ $allergy->allergen }} - {{ $allergy->reaction }}</p>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Antécédents Médicaux -->
        <div class="accordion" id="accordionMedicalHistory">
            <div class="accordion-item">
                <div class="card mt-2">
                    <h6 class="mb-0 accordion-header" id="headingMedicalHistory">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseMedicalHistory" aria-expanded="true"
                           aria-controls="collapseMedicalHistory" onclick="toggleIcon('medicalHistory')">
                            <span>{{ __('Antécédents Médicaux') }}</span>
                            <x-toggle-icon-component id="medicalHistory"/>
                        </a>
                    </h6>
                    <div id="collapseMedicalHistory" class="accordion-collapse collapse show"
                         aria-labelledby="headingMedicalHistory">
                        <div class="card-body">
                            @foreach($medicalHistories as $history)
                                <p>{{ $history->history_type }}: {{ $history->description }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rapports de consultation et résultats d'examen -->
        <!-- Vaccinations -->

        <div class="accordion" id="accordionReports">
            <div class="accordion-item">
                <div class="card">
                    <h6 class="mb-0 accordion-header" id="headingReports">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseReports" aria-expanded="true"
                           aria-controls="collapseReports"
                           onclick="toggleIcon('reports')">
                            <span>{{ __('Rapports de Consultation') }}</span>
                            <x-toggle-icon-component id="reports"/>
                        </a>
                    </h6>
                    <div id="collapseReports" class="accordion-collapse collapse show"
                         aria-labelledby="headingReports">
                        <div class="card-body">
                            @foreach($consultationReports as $report)
                                <p>{{ $report->consultation_date }}: {{ $report->final_diagnosis }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordionExams">
            <div class="accordion-item">
                <div class="card mt-2">
                    <h6 class="mb-0 accordion-header" id="headingExams">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseExams" aria-expanded="true" aria-controls="collapseExams"
                           onclick="toggleIcon('exams')">
                            <span>{{ __('Résultats d\'Examen') }}</span>
                            <x-toggle-icon-component id="exams"/>
                        </a>
                    </h6>
                    <div id="collapseExams" class="accordion-collapse collapse show"
                         aria-labelledby="headingExams">
                        <div class="card-body">
                            @foreach($examResults as $result)
                                <p>{{ $result->exam_date }}: {{ $result->exam_type }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordionVaccinations">
            <div class="accordion-item">
                <div class="card mt-2">
                    <h6 class="mb-0 accordion-header" id="headingVaccinations">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseVaccinations" aria-expanded="true"
                           aria-controls="collapseVaccinations" onclick="toggleIcon('vaccinations')">
                            <span>{{ __('Vaccinations') }}</span>
                            <x-toggle-icon-component id="vaccinations"/>
                        </a>
                    </h6>
                    <div id="collapseVaccinations" class="accordion-collapse collapse show"
                         aria-labelledby="headingVaccinations">
                        <div class="card-body">
                            @foreach($vaccinations as $vaccination)
                                <p>{{ $vaccination->vaccine_name }} - {{ $vaccination->vaccination_date }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion" id="accordionMedicaments">
            <div class="accordion-item">
                <div class="card mt-2">
                    <h6 class="mb-0 accordion-header" id="headingMedicaments">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseMedicaments" aria-expanded="true"
                           aria-controls="collapseMedicaments" onclick="toggleIcon('medicaments')">
                            <span>{{ __('Liste des Médicaments') }}</span>
                            <x-toggle-icon-component id="medicaments"/>
                        </a>
                    </h6>
                    <div id="collapseMedicaments" class="accordion-collapse collapse show"
                         aria-labelledby="headingMedicaments">
                        <div class="card-body">
                            @foreach($medications as $medication)
                                <p>{{ $medication->medication_name }} - {{ $medication->dosage }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

