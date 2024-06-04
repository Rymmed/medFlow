@extends('layouts.user_type.auth')

@section('content')

    <div>
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('{{url('../assets/img/bg/pngtree.jpg')}}'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="avatar avatar-xl position-relative">
                            <img src="{{asset('assets/img/bruce-mars.jpg')}}" alt="..." class="w-100 border-radius-lg shadow-sm">
                            <a href="javascript:;" class="btn btn-sm btn-icon-only bg-gradient-light position-absolute bottom-0 end-0 mb-n2 me-n2">
                                <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Image"></i>
                            </a>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                            </h5>
{{--                            <p class="mb-0 font-weight-bold text-sm">--}}
{{--                                {{ auth()->user()->role }}--}}
{{--                            </p>--}}
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                <li class="nav-item">
                                    <a id="profile-tab" class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab" href="javascript:;"
                                       role="tab" aria-controls="overview" aria-selected="true">
                                        <i class="fa fa-solid fa-address-card"></i>
                                        <span class="ms-0">{{ __('Informations Personnelles') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a id="security-tab" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" href="javascript:;" role="tab" aria-controls="teams" aria-selected="false">
                                        <i class="fa fa-solid fa-lock"></i>
                                        <span class="ms-1">{{ __('Sécurité') }}</span>
                                    </a>
                                </li>
                                @if(auth()->user()->role === 'doctor')
                                <li class="nav-item">
                                    <a href="#availability-form" id="availability-tab" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" role="tab" aria-controls="teams" aria-selected="false">
                                        <i class="fa fa-solid fa-business-time"></i>
                                        <span class="ms-1">{{ __('Horaires') }}</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="card" id="profile-form">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Profil') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user.update-profile') }}" method="POST" role="form text-left">
                        @csrf
                        @method('PUT')
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
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="alert-success" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <!-- Prénom -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="firstName" class="form-control-label">{{ __('Prénom') }}</label>
                                    <div class="@error('user.firstName')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->firstName}}" type="text" placeholder="{{ __('Entrez votre prénom') }}" id="firstName" name="firstName">
                                        @error('firstName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Nom -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="lastName" class="form-control-label">{{ __('Nom') }}</label>
                                    <div class="@error('user.lastName')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->lastName}}" type="text" placeholder="{{ __('Entrez votre nom') }}" id="lastName" name="lastName">
                                        @error('lastName')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">{{ __('Email') }}</label>
                                    <div class="@error('email')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->email }}" type="email" placeholder="{{ __('Entrez votre adresse email') }}" id="email" name="email">
                                        @error('email')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Date de naissance -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="dob" class="form-control-label">{{ __('Date de naissance') }}</label>
                                    <div class="@error('dob')border border-danger rounded-3 @enderror">
                                        <input class="form-control" value="{{ auth()->user()->dob }}" type="date" id="dob" name="dob">
                                        @error('dob')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Numéro de téléphone -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="phone_number" class="form-control-label">{{ __('Numéro de téléphone') }}</label>
                                    <div class="@error('user.phone_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="{{ __('Entrez votre numéro de téléphone') }}" id="phone_number" name="phone_number" value="{{ auth()->user()->phone_number }}">
                                        @error('phone_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @if(auth()->user()->role === 'patient')
                            <!-- Numéro de CIN -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="cin_number" class="form-control-label">{{ __('Numéro de CIN') }}</label>
                                    <div class="@error('user.cin_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="{{ __('Entrez votre numéro d\'identité nationnale') }}" id="cin_number" name="cin_number" value="{{ auth()->user()->cin_number }}">
                                        @error('cin_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Numéro d'assurance -->
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="insurance_number" class="form-control-label">{{ __('Numéro d\'assurance') }}</label>
                                    <div class="@error('user.insurance_number')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="text" placeholder="{{ __('Entrez votre numéro d\'assurance') }}" id="insurance_number" name="insurance_number" value="{{ auth()->user()->insurance_number }}">
                                        @error('insurance_number')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Sauvegarder' }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" id="security-form" style="display: none;">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Mot de passe et Sécuité') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('user.update-password') }}" method="POST" role="form text-left">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="current_password" class="form-control-label">{{ __('Mot de passe actuel') }}</label>
                                    <input class="form-control @error('current_password') border border-danger rounded-3 @enderror" type="password" placeholder="{{ __('Entrez votre mot de passe actuel') }}" id="current_password" name="current_password">
                                    @error('current_password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password" class="form-control-label">{{ __('Nouveau mot de passe') }}</label>
                                    <input class="form-control @error('new_password') border border-danger rounded-3 @enderror" type="password" placeholder="{{ __('Entrez votre nouveau mot de passe') }}" id="new_password" name="new_password">
                                    @error('new_password')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="new_password_confirmation" class="form-control-label">{{ __('Confirmation du nouveau mot de passe') }}</label>
                                    <input class="form-control @error('new_password_confirmation') border border-danger rounded-3 @enderror" type="password" placeholder="{{ __('Confirmez votre mot de passe') }}" id="new_password_confirmation" name="new_password_confirmation">
                                    @error('new_password_confirmation')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Sauvegarder') }}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card" id="availability-form" style="display: none;">
                <div class="card-header pb-0 px-3">
                    <h6 class="mb-0">{{ __('Horaires de travail') }}</h6>
                </div>
                <div class="card-body pt-4 p-3">
                    <form action="{{ route('availability.update', ['availability'=>auth()->user()->id]) }}" method="POST" role="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                            <div class="m-3  alert alert-success alert-dismissible fade show" id="success-message" role="alert">
                            <span class="alert-text text-white">
                            {{ session('success') }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <i class="fa fa-close" aria-hidden="true"></i>
                                </button>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_time" class="form-control-label">{{ __('Heure d\'ouverture') }}</label>
                                    <div class="@error('start_time')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="time" id="start_time" name="start_time" value="{{ $availability->start_time }}">
                                        @error('start_time')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="end_time" class="form-control-label">{{ __('Heure de fermeture') }}</label>
                                    <div class="@error('end_time')border border-danger rounded-3 @enderror">
                                        <input class="form-control" type="time" id="end_time" name="end_time" value="{{ $availability->end_time }}">
                                        @error('end_time')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="consultation_duration" class="form-control-label">{{ __('Durée de la consultation (minutes)') }}</label>
                                    <div class="@error('consultation_duration')border border-danger rounded-3 @enderror">
                                        <input class="js-example-basic-multiple form-control" type="number" id="consultation_duration" name="consultation_duration" value="{{ $availability->consultation_duration }}">
                                        @error('consultation_duration')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="days_of_week" class="form-control-label">{{ __('Jours de travail') }}</label>
                                    <div class="@error('days_of_week') border border-danger rounded-3 @enderror">
                                        <select class="form-control" id="days_of_week" name="days_of_week[]" multiple>
                                            @foreach(['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $index => $day)
                                                <option value="{{ $index }}" {{ $availability->days_of_week && in_array($index, json_decode($availability->days_of_week)) ? 'selected' : '' }}>{{ $day }}</option>
                                            @endforeach
                                        </select>
                                        @error('days_of_week')
                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Sauvegarder' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <script>
        document.getElementById('security-tab').addEventListener('click', function() {
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('availability-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'block';
        });
        document.getElementById('profile-tab').addEventListener('click', function() {
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('availability-form').style.display = 'none';
            document.getElementById('profile-form').style.display = 'block';
        });
        document.getElementById('availability-tab').addEventListener('click', function() {
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('availability-form').style.display = 'block';
        });
        document.addEventListener('DOMContentLoaded', function () {
            const daysOfWeekSelect = document.getElementById('days_of_week');
            const choices = new Choices(daysOfWeekSelect, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Sélectionnez des jours de travail',
                shouldSort: false,
                itemSelectText: 'Appuyer pour séléctionner',
                allowHTML: true,
            });
        });
    </script>
@endsection
