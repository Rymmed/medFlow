@extends('layouts.user_type.guest')

@section('content')
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">{{ __('Bienvenue') }}</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>{{ __('Nom') }}</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="{{ __('Entrez votre nom') }}" name="lastName" id="lastName" aria-label="lastName" aria-describedby="lastName" value="{{ old('lastName') }}">
                                                    @error('nom')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{ __('Prénom') }}</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="{{ __('Entrez votre prénom') }}" name="firstName" id="firstName" aria-label="firstName" aria-describedby="firstName" value="{{ old('firstName') }}">
                                                    @error('prenom')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{__('Email')}}</label>
                                                <div class="mb-3">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('Entrez votre adresse email') }}" aria-label="Email" aria-describedby="email-addon">
                                                    @error('email')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{__('Mot de passe')}}</label>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('Entrez votre mot de passe') }}" aria-label="Password" aria-describedby="password-addon">
                                                    @error('password')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{ __('Confirmation du mot de passe') }}</label>
                                                <div class="mb-3">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirmez votre mot de passe') }}" required autocomplete="new-password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>{{ __('Date de naissance') }}</label>
                                                <div class="mb-3">
                                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                                    @error('dob')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{ __('Numéro de téléphone') }}</label>
                                                <div class="mb-3">
                                                    <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="{{ __('Entrez votre numéro de téléphone') }}">
                                                    @error('phone_number')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>{{ __('Type de compte') }}</label>
                                                <div class="mb-3">
                                                    <select id="role" class="form-control" name="role" required>
                                                        <option value="patient">Patient</option>
                                                        <option value="doctor">Médecin</option>
                                                    </select>
                                                </div>
                                                <div id="patientFields" class="specific-fields" style="display: block;">
                                                    <label for="cin_number">{{ __('Numéro de CIN') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="cin_number" id="cin_number" placeholder="{{ __('Entrez votre numéro d\'identité nationnale') }}">
                                                        @error('cin_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <label for="insurance_number">{{ __('N° d\'assurance') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="insurance_number" id="insurance_number" placeholder="{{ __('Entrez votre numéro d\'assurance') }}">
                                                        @error('insurance_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div id="doctorFields" class="specific-fields" style="display: none;">
                                                    <label for="speciality">{{ __('Spécialité') }}</label>
                                                    <div class="mb-3">
                                                        <select class="form-select" name="speciality" id="speciality">
                                                            <option value="" disabled selected>{{ __('Sélectionner une spécialité') }}</option>
                                                            @foreach(config('specialities') as $speciality)
                                                                <option value="{{ $speciality }}">{{ $speciality }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('speciality')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <label for="registration_number">{{ __('N° d\'inscription à l\'ordre des médecins') }}</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="registration_number" id="registration_number" placeholder="{{ __('Entrez votre numéro d\'inscription dans l\'ordre des médecins') }}">
                                                        @error('registration_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">{{__('S’inscrire')}}</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        {{__('Vous avez déjà un compte ?')}}
                                        <a href="{{ route('login')}}" class="text-info text-gradient font-weight-bold">{{__('Se connecter')}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{url('assets/img/bg/pngtree.jpg')}}')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var patientFields = document.getElementById('patientFields');
            var doctorFields = document.getElementById('doctorFields');

            if (role === 'patient') {
                patientFields.style.display = 'block';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = true;
                });
                doctorFields.style.display = 'none';
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
            } else if (role === 'doctor') {
                patientFields.style.display = 'none';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
                doctorFields.style.display = 'block';
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = true;
                });
            } else {
                patientFields.style.display = 'none';
                doctorFields.style.display = 'none';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
            }
        });
    </script>
@endsection
