@extends('layouts.user_type.auth')

@section('content')

    <div>
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                 style="background-image: url('{{url('../assets/img/bg/pngtree.jpg')}}'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
            <div class="card card-body blur shadow-blur mx-4 mt-n6">
                <div class="row gx-4">
                    <div class="col-auto">
                        <div class="position-relative">
                            <x-profile-image></x-profile-image>
                            <x-edit-image-btn></x-edit-image-btn>
                        </div>
                    </div>
                    <div class="col-auto my-auto">
                        <div class="h-100">
                            <h5 class="mb-1">
                                {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                            </h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                        <div class="nav-wrapper position-relative end-0">
                            <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                <li class="nav-item">
                                    <a id="profile-tab" class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab"
                                       href="javascript:;"
                                       role="tab" aria-controls="overview" aria-selected="true">
                                        <i class="fa fa-solid fa-address-card"></i>
                                        <span class="ms-0">{{ __('Informations Personnelles') }}</span>
                                    </a>
                                </li>
                                @if(auth()->user()->role === 'patient')
                                    <li class="nav-item">
                                        <a id="medicalRecord-tab" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab"
                                           href="javascript:;" role="tab" aria-controls="teams" aria-selected="false">
                                            <i class="fa fa-solid fa-lock"></i>
                                            <span class="ms-1">{{ __('Dossier Médical') }}</span>
                                        </a>
                                    </li>
                                @endif
                                @if(auth()->user()->role === 'doctor')
                                    <li class="nav-item">
                                        <a href="#availability-form" id="availability-tab"
                                           class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" role="tab"
                                           aria-controls="teams" aria-selected="false">
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
            <x-general-info></x-general-info>
            <x-security></x-security>
            @if(auth()->user()->role === 'patient')
                <div class="card" id="medicalRecord-form" style="display: none;">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">{{ __('Dossier Médical') }}</h6>
                    </div>
                    <div class="card-body pt-4 p-3">
                        {{--                    <form action="{{ route('user.update-password') }}" method="POST" role="form text-left">--}}
                        {{--                        @csrf--}}
                        {{--                        @method('PUT')--}}
                        {{--                        <div class="row">--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="current_password"--}}
                        {{--                                           class="form-control-label">{{ __('Mot de passe actuel') }}</label>--}}
                        {{--                                    <input--}}
                        {{--                                        class="form-control @error('current_password') border border-danger rounded-3 @enderror"--}}
                        {{--                                        type="password" placeholder="{{ __('Entrez votre mot de passe actuel') }}"--}}
                        {{--                                        id="current_password" name="current_password">--}}
                        {{--                                    @error('current_password')--}}
                        {{--                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>--}}
                        {{--                                    @enderror--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="new_password"--}}
                        {{--                                           class="form-control-label">{{ __('Nouveau mot de passe') }}</label>--}}
                        {{--                                    <input--}}
                        {{--                                        class="form-control @error('new_password') border border-danger rounded-3 @enderror"--}}
                        {{--                                        type="password" placeholder="{{ __('Entrez votre nouveau mot de passe') }}"--}}
                        {{--                                        id="new_password" name="new_password">--}}
                        {{--                                    @error('new_password')--}}
                        {{--                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>--}}
                        {{--                                    @enderror--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                            <div class="col-md-4">--}}
                        {{--                                <div class="form-group">--}}
                        {{--                                    <label for="new_password_confirmation"--}}
                        {{--                                           class="form-control-label">{{ __('Confirmation du nouveau mot de passe') }}</label>--}}
                        {{--                                    <input--}}
                        {{--                                        class="form-control @error('new_password_confirmation') border border-danger rounded-3 @enderror"--}}
                        {{--                                        type="password" placeholder="{{ __('Confirmez votre mot de passe') }}"--}}
                        {{--                                        id="new_password_confirmation" name="new_password_confirmation">--}}
                        {{--                                    @error('new_password_confirmation')--}}
                        {{--                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>--}}
                        {{--                                    @enderror--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        {{--                        <div class="d-flex justify-content-end">--}}
                        {{--                            <button type="submit"--}}
                        {{--                                    class="btn bg-gradient-dark btn-md mt-4 mb-4">{{ __('Sauvegarder') }}</button>--}}
                        {{--                        </div>--}}
                        {{--                    </form>--}}
                    </div>
                </div>
            @endif
            @if(auth()->user()->role === 'doctor')
                <x-availability :availability="$availability"></x-availability>
            @endif
        </div>

    </div>
    <script>
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
        document.getElementById('medicalRecord-tab').addEventListener('click', function () {
            // document.getElementById('availability-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('medicalRecord-form').style.display = 'block';
        });
        document.getElementById('profile-tab').addEventListener('click', function () {
            // document.getElementById('availability-form').style.display = 'none';
            // document.getElementById('medicalRecord-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'block';
            document.getElementById('profile-form').style.display = 'block';
        });
        document.getElementById('availability-tab').addEventListener('click', function () {
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('availability-form').style.display = 'block';
        });
    </script>
@endsection
