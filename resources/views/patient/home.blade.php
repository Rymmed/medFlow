@extends('layouts.user_type.auth')
@php
    $specialties = config('specialties');
@endphp
@section('content')
    <div class="row">
        <!-- Informations Personnelles -->
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="text-center mt-5">
                    <div class="col-auto">
                        <div class="position-relative">
                            @if(auth()->user()->profile_image)
                                <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile Photo"
                                     class="avatar avatar-xxl border-radius-section shadow">
                            @else
                                <img src="{{ asset('assets/img/default-profile.jpg') }}" alt="Default Profile Photo"
                                     class="avatar avatar-xxl border-radius-section shadow">
                            @endif
                            <!-- Formulaire de téléchargement caché -->
                            <form id="profile-image-form" action="{{ route('user.updateProfileImg') }}" method="POST"
                                  enctype="multipart/form-data" style="display:none;">
                                @csrf
                                @method('PUT')
                                <input type="file" name="profile_image" id="profile_image_input"
                                       onchange="document.getElementById('profile-image-form').submit();">
                            </form>
                            <a href="javascript:;"
                               class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 mb-n2"
                               onclick="document.getElementById('profile_image_input').click();">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
                                   title="Edit Image"></i>
                            </a>
                        </div>
                    </div>
                    <h6 class="card-title mt-3">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>
                    <p class=" mb-0 font-weight-bold text-sm">{{ \Carbon\Carbon::parse(auth()->user()->dob)->age }}
                        {{ __('ans') }},
                        @if(auth()->user()->gender === 0)
                            {{ __('Homme') }}
                        @else
                            {{ __('Femme') }}
                        @endif
                    </p>
                </div>
                <hr class="horizontal dark mt-2">
                <div class="card-body">
                    <h6 class="mb-0 accordion-header" id="headingInfos">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseInfos" aria-expanded="true" aria-controls="collapseInfos"
                           onclick="toggleIcon('infos')">
                            <span>{{ __('Informations Générales') }}</span>
                            <x-toggle-icon-component id="infos"/>
                        </a>
                    </h6>
                    <div id="collapseInfos" class="accordion-collapse collapse show" aria-labelledby="headingInfos">
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                                <p class="text-sm">{{ __('Date de naissance') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->dob }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                                <p class="text-sm">{{ __('Numéro de téléphone') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->phone_number }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                                <p class="text-sm">{{ __('Adresse') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->city }}, {{ auth()->user()->country }}</p>
                            </div>
                        </div>
                    </div>
                    <!-- Liste des Médecins -->
                    <h6 class="mb-0 accordion-header" id="headingDoctors">
                        <a class="accordion-button" type="button" data-bs-toggle="collapse"
                           data-bs-target="#collapseDoctors" aria-expanded="true" aria-controls="collapseDoctors"
                           onclick="toggleIcon('doctors')">
                            <span>{{ __('Mes Médecins') }}</span>
                            <x-toggle-icon-component id="doctors"/>
                        </a>
                    </h6>
                    <div id="collapseDoctors" class="accordion-collapse collapse show" aria-labelledby="headingDoctors">
                        @foreach($doctors as $doctor)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $doctor->profile_image }}" alt="Photo de profil"
                                     class="rounded-circle me-3" style="width: 50px; height: 50px;">
                                <div>
                                    <h6 class="m-0">{{ $doctor->firstName }} {{ $doctor->lastName }}</h6>
                                    <p class="m-0">{{ $doctor->speciality }}</p>
                                </div>
                                <div class="ms-auto">
                                    <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Allergies -->
            <div class="accordion" id="accordionAllergies">
                <div class="accordion-item">
                    <div class="card mt-2">
                        <h6 class="mb-0 accordion-header" id="headingAllergies">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                               data-bs-target="#collapseAllergies" aria-expanded="true"
                               aria-controls="collapseAllergies" onclick="toggleIcon('allergies')">
                                <span>{{ __('Allergies') }}</span>
                                <x-toggle-icon-component id="allergies"/>
                            </a>
                        </h6>
                        <div id="collapseAllergies" class="accordion-collapse collapse show"
                             aria-labelledby="headingAllergies">
                            <div class="card-body">
                                @foreach($allergies as $allergy)
                                    <p>{{ $allergy->allergen }} - {{ $allergy->reaction }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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
        </div>
        <!-- Rapports de consultation et résultats d'examen -->
        <!-- Vaccinations -->
        <div class="col-md-4">
            <div class="accordion" id="accordionReports">
                <div class="accordion-item">
                    <div class="card">
                        <h6 class="mb-0 accordion-header" id="headingReports">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                               data-bs-target="#collapseReports" aria-expanded="true" aria-controls="collapseReports"
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
                        <div id="collapseExams" class="accordion-collapse collapse show" aria-labelledby="headingExams">
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
        </div>


        <div class="col-md-4 mb-2">

            <!-- Rendez-vous à venir -->
            <div class="accordion" id="accordionAppointments">
                <div class="accordion-item">
                    <div class="card">
                        <h6 class="mb-0 accordion-header" id="headingAppointments">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                               data-bs-target="#collapseAppointments" aria-expanded="true"
                               aria-controls="collapseAppointments" onclick="toggleIcon('appointments')">
                                <span>{{ __('Rendez-vous à venir') }}</span>
                                <x-toggle-icon-component id="appointments"/>
                            </a>
                        </h6>
                        <div id="collapseAppointments" class="accordion-collapse collapse show"
                             aria-labelledby="headingAppointments">
                            <div class="card-body">
                                @foreach($upcomingAppointments as $appointment)
                                    <div class="row bg-transparent-blue py-1 mx-0 w-100 border-radius-md">
                                        <div class="col-md-8">
                                            <p class="text-sm text-dark">{{ $appointment->consultation_type }}</p>
                                        </div>
                                        <div class="col-md-4">
                                            <p class="text-sm-end text-dark">{{ $appointment->start_date }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rendez-vous récemment pris -->
            <div class="accordion" id="accordionRecentAppointments">
                <div class="accordion-item">
                    <div class="card mt-2">
                        <h6 class="mb-0 accordion-header" id="headingRecentAppointments">
                            <a class="accordion-button" type="button" data-bs-toggle="collapse"
                               data-bs-target="#collapseRecentAppointments" aria-expanded="true"
                               aria-controls="collapseRecentAppointments" onclick="toggleIcon('recentAppointments')">
                                <span>{{ __('Rendez-vous récemment pris') }}</span>
                                <x-toggle-icon-component id="recentAppointments"/>
                            </a>
                        </h6>
                        <div id="collapseRecentAppointments" class="accordion-collapse collapse show"
                             aria-labelledby="headingRecentAppointments">
                            <div class="card-body">
                                @foreach($recentAppointments as $appointment)
                                    <div class="row bg-transparent-blue py-2 mx-0 w-100 border-radius-md">
                                        <div class="col-md-8">
                                            <p class="text-sm">{{ $appointment->consultation_type }}</p>
                                        </div>
                                        <div class="col-md-4 text-sm-end">
                                            <p class="text-sm">{{ $appointment->start_date }}</p>
                                        </div>
                                    </div>
                                @endforeach
                                <a type="button"
                                   class="bg-gradient-dark text-white text-center btn btn-block btn-default mt-3 mb-3 px-2 py-2"
                                   data-bs-toggle="modal" data-bs-target="#exampleModalMessage">
                                    <i class="far fa-calendar-plus me-1"></i>
                                    <span>{{ __('Réserver un autre rendez-vous') }}</span>
                                </a>
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
                                                <form role="form" action="{{ route('search_doctors') }}" method="POST">
                                                    @csrf
                                                    <div class="form-group mb-3">
                                                        <select id="speciality" name="speciality[]" class="form-control"
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
                    </div>
                </div>
            </div>

            <!-- Liste des Médicaments -->
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

        document.addEventListener('DOMContentLoaded', function () {
            const specialitySelect = document.getElementById('speciality');
            const choices = new Choices(specialitySelect, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Sélectionnez des spécialités',
                itemSelectText: 'Appuyer pour séléctionner',
                allowHTML: true,
            });
        });
    </script>
@endsection
