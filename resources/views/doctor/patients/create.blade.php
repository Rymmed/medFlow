@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid py-4">
        <div class="card" id="profile-form">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Ajouter un patient ') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('doctor-patients.store') }}" method="POST" role="form text-left">
                    @csrf
                    @if($errors->any())
                        <div class="mt-3  alert alert-primary alert-dismissible fade show" role="alert">
                            <span class="alert-text text-white">
                            {{$errors->first()}}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success"
                             role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <i class="fa fa-close" aria-hidden="true"></i>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <!-- Nom -->
                        <div class="col-md-4">
                            <div class="form-group">
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
                        </div>
                        <!-- Prénom -->
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
                        <!-- Email -->
                        <div class="col-md-4">
                            <div class="form-group">
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
                        <div class="col-md-4">
                            <div class="form-group">
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
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
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
                        </div>
                        <!-- Genre -->
                        <div class="col-md-4">
                            <div class="form-group">
                        <label for="dob">{{ __('Date de naissance') }} *</label>
                        <div class="mb-3">
                            <input type="date" class="form-control" name="dob" id="dob"
                                   required>
                            @error('dob')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                            </div></div>
                        <div class="col-md-4">
                            <div class="form-group">
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

                    </div>
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
                                    <option value="" selected>Non Connu</option>
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
                                       id="alcohol_no" value="0">
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
                                       id="smoking_no" value="0">
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
                                       name="sedentary_lifestyle" id="sedentary_no" value="1">
                                <label class="form-check-label" for="sedentary_no">Non</label>
                            </div>
                            @error('sedentary_lifestyle')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Ajouter' }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
