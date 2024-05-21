@extends('layouts.user_type.auth')
@php
    $specialties = config('specialties');
@endphp
@section('content')
    <div class="row">
        <div class="col-md-4 mb-2">
            <div class="card">
                <div class="text-center mt-5">
                    <a href="javascript:;">
                        <img class="avatar avatar-xxl border-radius-section shadow" src="{{asset('assets/img/bruce-mars.jpg')}}">
                    </a>
                    <h6 class="card-title">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>
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
                        <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInfos" aria-expanded="false" aria-controls="collapseInfos" onclick="toggleIcon('infos')">
                            <span>{{ __('Informations Générale') }}</span>
                            <x-toggle-icon-component id="infos"/>
                        </a>
                    </h6>
                    <div id="collapseInfos" class="accordion-collapse collapse" aria-labelledby="headingInfos">
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                               <p class="text-sm"> {{ __('Date de naissance') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->dob }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                               <p class="text-sm"> {{ __('Numéro  de téléphone') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->phone_number }}</p>
                            </div>
                        </div>
                        <div class="row mx-0 w-100">
                            <div class="col-7">
                               <p class="text-sm"> {{ __('Adresse') }}</p>
                            </div>
                            <div class="col-5">
                                <p class="text-sm">{{ auth()->user()->city }}, {{ auth()->user()->country }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Partie pour la liste des médecins -->
                    <h6 class="mb-0 accordion-header" id="headingDoctors">

                        <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDoctors" aria-expanded="false" aria-controls="collapseDoctors" onclick="toggleIcon('doctors')">
                            <span>{{ __('Mes Médecins') }}</span>
                            <x-toggle-icon-component id="doctors"/>
                        </a>
                    </h6>
                    <!-- Ligne pour chaque médecin -->
                    <div id="collapseDoctors" class="accordion-collapse collapse" aria-labelledby="headingDoctors">
                        <div class="d-flex align-items-center mb-3">
                            <!-- Photo de profil -->
                            <img src="path_to_image" alt="Photo de profil" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                            <!-- Nom, prénom et spécialité -->
                            <div>
                                <h6 class="m-0">Nom Prénom</h6>
                                <p class="m-0">Spécialité</p>
                            </div>
                            <!-- Option pour afficher plus -->
                            <div class="ms-auto">
                                <a href="#"><i class="fas fa-ellipsis-v"></i></a>
                            </div>
                        </div>
                        <!-- Ajoutez d'autres médecins ici -->
                        </div>
                </div>


            </div>
            <!-- Liste des Médicaments -->
            <div class="accordion" id="accordionMedicaments">
                <div class="accordion-item">
                    <div class="card mt-2 ">
                        <!-- En-tête de la Liste des Médicaments -->
                            <h6 class="mb-0 accordion-header" id="headingMedicaments">
                                <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMedicaments" aria-expanded="false" aria-controls="collapseMedicaments" onclick="toggleIcon('medicaments')">
                                    <span>Liste des Médicaments</span>
                                    <x-toggle-icon-component id="medicaments"/>
                                </a>
                            </h6>
                        <!-- Contenu de la Liste des Médicaments -->
                        <div id="collapseMedicaments" class="accordion-collapse collapse" aria-labelledby="headingMedicaments" data-parent="#accordionMedicaments">
                            <div class="card-body">
                                <!-- Contenu de la Liste des Médicaments -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Diagnostics -->
            <div class="accordion" id="accordionDiagnostics">
                <div class="accordion-item">
                    <div class="card mt-2">
                    <!-- En-tête des Diagnostics -->
                        <h6 class="mb-0 accordion-header" id="headingDiagnostics">
                            <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiagnostics" aria-expanded="false" aria-controls="collapseDiagnostics" onclick="toggleIcon('diagnostics')">
                                <span>Diagnostics</span>
                                <x-toggle-icon-component id="diagnostics"/>
                            </a>
                        </h6>

                    <!-- Contenu des Diagnostics -->
                    <div id="collapseDiagnostics" class="accordion-collapse collapse" aria-labelledby="headingDiagnostics" data-parent="#accordionDiagnostics">
                        <div class="card-body">
                            <!-- Contenu des Diagnostics -->
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 d-flex flex-column mb-2">
            <div class="accordion" id="accordionAppointments">
                <div class="accordion-item">
                    <div class="card">
                        <h5 class="mb-0 accordion-header" id="headingAppointments">
                            <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAppointments" aria-expanded="false" aria-controls="collapseAppointments" onclick="toggleIcon('appointments')">
                                <span>Rendez-vous à venir</span>
                                <x-toggle-icon-component id="appointments"/>
                            </a>
                        </h5>

                        <div id="collapseAppointments" class="accordion-collapse collapse" aria-labelledby="headingAppointments" data-parent="#accordionAppointments">
                            <div class="card-body d-flex flex-column pt-1">

                                <div class="row bg-transparent-blue py-1 mx-0 w-100 border-radius-md  ">
                                    <div class="col-md-8">
                                        <p class="text-sm">General check-up </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p class="text-sm-end">Aug 12 </p>
                                    </div>
                                </div>
                                <div class="row bg-transparent-blue py-2 mx-0 w-100 border-radius-md mt-2">
                                    <div class="col-md-8">
                                        General check-up
                                    </div>
                                    <div class="col-md-4 text-sm-end">
                                        Aug 12
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                </div>
            </div>
            <div class="accordion" id="accordionAppointment">
                <div class="accordion-item">
                    <div class="card mt-2">
                        <h5 class="mb-0 accordion-header" id="headingAppointment">
                            <a class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAppointment" aria-expanded="false" aria-controls="collapseAppointment" onclick="toggleIcon('appointment')">
                                <span>Rendez-vous récemment pris</span>
                                <x-toggle-icon-component id="appointment"/>
                            </a>
                        </h5>
                        <div id="collapseAppointment" class="accordion-collapse collapse" aria-labelledby="headingAppointment" data-parent="#accordionAppointment">
                            <div class="card-body d-flex flex-column pt-1">
                        <div class="row bg-transparent-blue py-2 mx-0 w-100 border-radius-md">
                            <div class="col-md-8">
                                General check-up
                            </div>
                            <div class="col-md-4 text-sm-end">
                                Aug 12
                            </div>
                        </div>
                        <a href="{{ route('search') }}" class="bg-gradient-dark text-white text-center border-radius-md mt-2 px-2 py-2">
                            <i class="far fa-calendar-plus me-1"></i>
                            <span>Réserver un autre rendez-vous</span>
                        </a>

                    </div>
                        </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <!-- Partie pour la liste des spécialités -->
                    <div class="mb-4">
                        <h5>Trouver des spécialistes</h5>
                        <div class="d-flex flex-wrap align-items-center">
                            <!-- Icône et titre de la spécialité -->
                            <div class="col-3   ">
                                <div class="icon icon-lg bg-gradient-faded-light justify-content-center">
                                    <x-gmdi-psychology class="icon-sm text-secondary"/>
                                </div>
                                <span class="text-xs ms-2">Spécialité 1</span>
                            </div>
                            <!-- Ajoutez d'autres spécialités ici -->
                        </div>
                        <!-- Option pour afficher plus -->
                        <a href="#" class="text-primary">Afficher plus</a>
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
</script>
@endsection


