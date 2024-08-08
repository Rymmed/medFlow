@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid py-4">
        <div class="card" id="profile-form">
            <div class="card-header pb-0 px-3">
                <h6 class="mb-0">{{ __('Modifier Médecin') }}</h6>
            </div>
            <div class="card-body pt-4 p-3">
                <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" role="form text-left">
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
                        <!-- Nom -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="lastName" class="form-control-label">{{ __('Nom') }}</label>
                                <div class="@error('user.lastName')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ $doctor->lastName }}" type="text" placeholder="{{ __('Entrez le nom') }}" id="lastName" name="lastName">
                                    @error('lastName')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <!-- Prénom -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="firstName" class="form-control-label">{{ __('Prénom') }}</label>
                                <div class="@error('user.firstName')border border-danger rounded-3 @enderror">
                                    <input class="form-control" value="{{ $doctor->firstName }}"  type="text" placeholder="{{ __('Entrez le prénom') }}" id="firstName" name="firstName">
                                    @error('firstName')
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
                                    <input class="form-control" value="{{ $doctor->email }}"  type="email" placeholder="{{ __('Entrez l\'adresse email') }}" id="email" name="email">
                                    @error('email')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="speciality" class="form-control-label">{{ __('Spécialité') }}</label>
                                <div class="@error('speciality')border border-danger rounded-3 @enderror">
                                    <select class="form-select" name="speciality" id="speciality"   >
                                        <option value="{{ $doctor->speciality }}" disabled selected>{{ $doctor->speciality }}</option>
                                        @foreach(config('specialities') as $speciality)
                                            <option value="{{ $speciality }}">{{ $speciality }}</option>
                                        @endforeach
                                    </select>
                                    @error('speciality')
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
                                    <input class="form-control" value="{{ $doctor->phone_number}}" type="text" placeholder="{{ __('Entrez le numéro de téléphone') }}" id="phone_number" name="phone_number">
                                    @error('phone_number')
                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ 'Modifier' }}</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection