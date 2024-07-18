@extends('layouts.user_type.guest')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-9 col-md-10 d-flex flex-column mx-auto">
                <div class="card card-plain mt-6">
                    <div class="card-header pb-0 text-left bg-transparent">
                        <h3 class="font-weight-bolder text-info text-gradient">{{ __('Créer Votre Compte') }}</h3>
                    </div>
                    <div class="card-body">
                        <div id="container" class="container mt-4">
                            <div class="progress px-1" style="height: 3px;">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                     aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="step-container d-flex justify-content-between">
                                <div class="step-circle" onclick="displayStep(1)">1</div>
                                <div class="step-circle" onclick="displayStep(2)">2</div>
                                <div class="step-circle" onclick="displayStep(3)">3</div>
                            </div>

                            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf
                                <div id="multi-step-form">
                                    <!-- Step 1 -->
                                    <div class="step step-1">
                                        {{--                                        <h3>{{ __('Informations Générales') }}</h3>--}}
                                        <label for="lastName">{{ __('Photo de profil') }}</label>
                                        <div class="mb-3">
                                            <input type="file" class="form-control" name="profile_image"
                                                   id="profile_image" accept="image/*">
                                            @error('professional_card')
                                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="lastName">{{ __('Nom') }} *</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control"
                                                           placeholder="{{ __('Entrez votre nom') }}" name="lastName"
                                                           id="lastName"
                                                           aria-label="lastName" aria-describedby="lastName"
                                                           value="{{ old('lastName') }}" required>
                                                    @error('lastName')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="firstName">{{ __('Prénom') }} *</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control"
                                                           placeholder="{{ __('Entrez votre prénom') }}"
                                                           name="firstName"
                                                           id="firstName" aria-label="firstName"
                                                           aria-describedby="firstName"
                                                           value="{{ old('firstName') }}" required>
                                                    @error('firstName')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="email">{{__('Email')}} *</label>
                                                <div class="mb-3">
                                                    <input type="email" class="form-control" name="email" id="email"
                                                           placeholder="{{ __('Entrez votre adresse email') }}"
                                                           aria-label="Email"
                                                           aria-describedby="email-addon" required>
                                                    @error('email')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="password">{{ __('Mot de passe') }} *</label>
                                                <div class="mb-3 position-relative">
                                                    <input type="password" class="form-control" name="password"
                                                           id="password"
                                                           placeholder="{{ __('Entrez votre mot de passe') }}"
                                                           aria-label="Password"
                                                           aria-describedby="password-addon" required>
                                                    <x-show-password :toggleComponent="'password'"></x-show-password>
                                                    @error('password')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="password-confirm">{{ __('Confirmer le mot de passe') }}
                                                    *</label>
                                                <div class="mb-3 position-relative align-content-center">
                                                    <input id="password-confirm" type="password" class="form-control"
                                                           name="password_confirmation"
                                                           placeholder="{{ __('Confirmez votre mot de passe') }}"
                                                           required
                                                           autocomplete="new-password">
                                                    <x-show-password
                                                        :toggleComponent="'password-confirm'"></x-show-password>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="gender">{{__('Genre') }} *</label>
                                                <div class="form-check mb-3">
                                                    <input type="radio" class="form-check-input" name="gender" id="male"
                                                           value="{{ \App\Enums\Gender::MALE }}">
                                                    <label class="custom-control-label"
                                                           for="male">{{__('Homme')}}</label>
                                                </div>
                                                <div class="form-check mb-3">
                                                    <input type="radio" class="form-check-input" name="gender"
                                                           id="female"
                                                           value="{{ \App\Enums\Gender::FEMALE }}">
                                                    <label class="custom-control-label"
                                                           for="female">{{__('Femme')}}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label for="dob">{{ __('Date de naissance') }}</label>
                                                <div class="mb-3">
                                                    <input type="date" class="form-control" name="dob" id="dob"
                                                           required>
                                                    @error('dob')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="phone_number">{{ __('Numéro de téléphone') }}</label>
                                                <div class="mb-3">
                                                    <input type="tel" class="form-control" name="phone_number"
                                                           id="phone_number"
                                                           placeholder="{{ __('Entrez votre n° de téléphone') }}">
                                                    @error('phone_number')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="role">{{ __('Type de compte') }}</label>
                                                <div class="mb-3">
                                                    <select id="role" class="form-control" name="role" required>
                                                        <option value="patient" selected>Patient</option>
                                                        <option value="doctor">Médecin</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-info bg-gradient next-step">Suivant</button>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="step step-2">
                                        <!-- Patient Fields -->
                                        <div id="patientFields" class="specific-fields" style="display: none;">
                                            {{--                                            <h3>Informations Personnelles de Santé</h3>--}}
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="height">{{ __('Taille (cm)')}}</label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="height"
                                                               id="height">
                                                        @error('height')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="weight">{{ __('Poids (kg)')}}</label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control" name="weight"
                                                               id="weight">
                                                        @error('weight')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="area">{{ __('Zone') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" name="area" id="area">
                                                            <option value="" selected></option>
                                                            @foreach(\App\Enums\PatientArea::getValues() as $area)
                                                                <option value="{{ $area }}">{{ $area }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('area')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="blood_group">{{ __('Groupe sanguin') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" name="blood_group" id="blood_group">
                                                            <option value="unknown" selected>Non Connu</option>
                                                            @foreach(\App\Enums\BloodGroup::getValues() as $bloodGroup)
                                                                <option
                                                                    value="{{ $bloodGroup }}">{{ $bloodGroup }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('blood_group')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="alcohol">{{ __('Consommation d\'alcool') }}</label>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input" name="alcohol"
                                                               id="alcohol_yes" value="1">
                                                        <label class="form-check-label" for="alcohol_yes">Oui</label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input" name="alcohol"
                                                               id="alcohol_no" value="0" checked>
                                                        <label class="form-check-label" for="alcohol_no">Non</label>
                                                    </div>
                                                    @error('alcohol')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="smoking">{{ __('Fumeur') }}</label>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                               id="smoking_yes" value="1">
                                                        <label class="form-check-label" for="smoking_yes">Oui</label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input" name="smoking"
                                                               id="smoking_no" value="0" checked>
                                                        <label class="form-check-label" for="smoking_no">Non</label>
                                                    </div>
                                                    @error('smoking')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="sedentary_lifestyle">{{ __('Activité Physique') }}</label>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input"
                                                               name="sedentary_lifestyle" id="sedentary_yes" value="0">
                                                        <label class="form-check-label" for="sedentary_yes">Oui</label>
                                                    </div>
                                                    <div class="form-check mb-3">
                                                        <input type="radio" class="form-check-input"
                                                               name="sedentary_lifestyle" id="sedentary_no" value="1"
                                                               checked>
                                                        <label class="form-check-label" for="sedentary_no">Non</label>
                                                    </div>
                                                    @error('sedentary_lifestyle')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Doctor Fields -->
                                        <div id="doctorFields" class="specific-fields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="speciality">{{ __('Spécialité') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" name="speciality" id="speciality"
                                                                required>
                                                            <option value="" disabled
                                                                    selected>{{ __('Sélectionner une spécialité') }}</option>
                                                            @foreach(config('specialities') as $speciality)
                                                                <option
                                                                    value="{{ $speciality }}">{{ $speciality }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('speciality')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="professional_card">{{ __('Carte professionnelle') }}</label>
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control" name="professional_card"
                                                               id="professional_card" accept="image/*">
                                                        @error('professional_card')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="office_phone_number">{{ __('Numéro de téléphone du bureau') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control"
                                                               name="office_phone_number" id="office_phone_number"
                                                               placeholder="{{ __('Entrez le n° de téléphone du bureau') }}">
                                                        @error('office_phone_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="office_address">{{ __('Adresse du cabinet') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="address"
                                                               id="office_address"
                                                               placeholder="{{ __('Entrez votre adresse') }}">
                                                        @error('office_address')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="office_city">{{ __('Ville') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="city"
                                                               id="office_city"
                                                               placeholder="{{ __('Entrez votre ville') }}">
                                                        @error('office_city')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="office_country">{{ __('Pays') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="country"
                                                               id="office_country"
                                                               placeholder="{{ __('Entrez votre pays') }}">
                                                        @error('country')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <button type="button" class="btn btn-info bg-gradient prev-step">Précédent</button>
                                        <button type="button" class="btn btn-info bg-gradient next-step">Suivant</button>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="step step-3">
                                        <h3>Step 3</h3>

                                        <!-- Address Fields -->
                                        <div id="patientFields2" class="specific-fields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="address">{{ __('Adresse') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="address"
                                                               id="address"
                                                               placeholder="{{ __('Entrez votre adresse') }}">
                                                        @error('address')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="city">{{ __('Ville') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="city" id="city"
                                                               placeholder="{{ __('Entrez votre ville') }}">
                                                        @error('city')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="country">{{ __('Pays') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="country"
                                                               id="country"
                                                               placeholder="{{ __('Entrez votre pays') }}">
                                                        @error('country')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="doctorFields2" class="specific-fields" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="start_time">{{ __('Heure de début') }}</label>
                                                    <div class="mb-3">
                                                        <input type="time" class="form-control" name="start_time"
                                                               id="start_time" required>
                                                        @error('start_time')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="end_time">{{ __('Heure de fin') }}</label>
                                                    <div class="mb-3">
                                                        <input type="time" class="form-control" name="end_time"
                                                               id="end_time" required>
                                                        @error('end_time')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label
                                                        for="consultation_duration">{{ __('Durée de la consultation (min)') }}</label>
                                                    <div class="mb-3">
                                                        <input type="number" class="form-control"
                                                               name="consultation_duration" id="consultation_duration"
                                                               min="1">
                                                        @error('consultation_duration')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="days_of_week">{{ __('Jours de travail') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" id="days_of_week"
                                                                name="days_of_week[]"
                                                                required multiple>
                                                            <option value="" disabled
                                                            >{{ __('Sélectionner vos jours') }}</option>
                                                            @foreach(['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $index => $day)
                                                                <option
                                                                    value="{{ $index }}">{{ $day }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label
                                                        for="consultation_types">{{ __('Types de consultation') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" name="consultation_types[]"
                                                                id="consultation_types" multiple required>
                                                            <option value="" disabled
                                                            >{{ __('Quels types offrez-vous ?') }}</option>
                                                            @foreach(\App\Enums\ConsultationType::getValues() as $type)
                                                                <option value="{{ $type }}">{{ $type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="online_fees">{{ __('Frais en ligne') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="online_fees"
                                                               id="online_fees">
                                                        @error('online_fees')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="home_service_fees">{{ __('Frais à domicile') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="home_service_fees"
                                                               id="home_service_fees">
                                                        @error('home_service_fees')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="in_person_fees">{{ __('Frais en personne') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="in_person_fees"
                                                               id="in_person_fees">
                                                        @error('in_person_fees')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-info bg-gradient prev-step">Précédent</button>
                                        <button type="submit" class="btn btn-info bg-gradient">{{ __('S\'inscrire') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="text-center px-lg-2 px-1">
                        <p class="mb-4 text-sm mx-auto">
                            {{ __('Déjà membre?') }}
                            <a href="{{ route('login') }}"
                               class="text-info text-gradient font-weight-bold">{{ __('Se connecter') }}</a>
                        </p>
                    </div>

                </div>
            </div>
            {{--            <div class="col-md-3">--}}
            {{--                <div class="oblique position-absolute top-0 h-100 d-md-flex d-none">--}}
            {{--                    <div class="oblique-image bg-cover position-absolute fixed-top ms-auto max-height-vh-100 h-100 z-index-0" style="background-image:url('{{url('assets/img/bg/pngtree.jpg')}}')"></div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const steps = document.querySelectorAll('.step');
            const nextButtons = document.querySelectorAll('.next-step');
            const prevButtons = document.querySelectorAll('.prev-step');
            const progressBar = document.querySelector('.progress-bar');
            const stepCircles = document.querySelectorAll('.step-circle');
            const roleSelect = document.getElementById('role');
            const patientFields = document.getElementById('patientFields');
            const patientFields2 = document.getElementById('patientFields2');
            const doctorFields = document.getElementById('doctorFields');
            const doctorFields2 = document.getElementById('doctorFields2');

            let currentStep = 0;

            function showStep(index) {
                steps.forEach((step, i) => {
                    step.style.display = i === index ? 'block' : 'none';
                    stepCircles[i].classList.toggle('active', i === index);
                });
                const progressPercent = (index / (steps.length - 1)) * 100;
                progressBar.style.width = progressPercent + '%';
            }

            function displayStep(stepNumber) {
                if (stepNumber >= 1 && stepNumber <= 3) {
                    steps[currentStep].style.display = 'none';
                    steps[stepNumber].style.display = 'block';
                    currentStep = stepNumber;
                    updateProgressBar();
                }
            }

            function updateProgressBar() {
                const progressPercent = (currentStep / (steps.length - 1)) * 100;
                progressBar.style.width = progressPercent + '%';
            }

            nextButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep < steps.length - 1) {
                        currentStep++;
                        showStep(currentStep);
                    }
                });
            });

            prevButtons.forEach(button => {
                button.addEventListener('click', () => {
                    if (currentStep > 0) {
                        currentStep--;
                        showStep(currentStep);
                    }
                });
            });

            function toggleFields() {
                if (roleSelect.value === 'patient') {
                    patientFields.style.display = 'block';
                    patientFields2.style.display = 'block';
                    doctorFields.style.display = 'none';
                    doctorFields2.style.display = 'none';
                } else {
                    patientFields.style.display = 'none';
                    patientFields2.style.display = 'none';
                    doctorFields.style.display = 'block';
                    doctorFields2.style.display = 'block';
                }
            }

            toggleFields();

            roleSelect.addEventListener('change', toggleFields);

            document.querySelector('.next-step').addEventListener('click', function () {
                toggleFields();
            });

            showStep(currentStep);
        });

        // speciality selection
        document.addEventListener('DOMContentLoaded', function () {
            const specialitySelect = document.getElementById('speciality');
            const choices = new Choices(specialitySelect, {
                removeItemButton: true,
                placeholder: true,
                itemSelectText: '',
                allowHTML: true,
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const daysOfWeekSelect = document.getElementById('days_of_week');
            const choices = new Choices(daysOfWeekSelect, {
                removeItemButton: true,
                placeholder: true,
                shouldSort: false,
                itemSelectText: '',
                allowHTML: true,
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            const consultationTypesSelect = document.getElementById('consultation_types');
            const choices = new Choices(consultationTypesSelect, {
                removeItemButton: true,
                placeholder: true,
                itemSelectText: '',
                allowHTML: true,
            });
        });

    </script>
@endsection
