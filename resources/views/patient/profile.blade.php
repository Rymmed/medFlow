@extends('layouts.user_type.auth')

@section('content')
        <div class="container-fluid">
            <div class="row mt-7">
                <div class="col-lg-4 col-md-4">
                    <div class="card card-body blur shadow-blur mx-4 mt-n6">
                        <div class="row gx-4">
                            <div class="col-auto">
                                <div class="position-relative">
                                    <x-profile-image :class="'avatar avatar-xl border-radius-section shadow'"></x-profile-image>
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
                        </div>
                        <div class="my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative">
                                <ul class="nav nav-pills nav-fill flex-column p-1 bg-transparent" role="tablist">
                                    <li class="nav-item">
                                        <a id="profile-tab" class="nav-link mb-0 px-0 py-1 active h-auto" data-bs-toggle="tab"
                                           href="javascript:;"
                                           role="tab" aria-controls="overview" aria-selected="true">
                                            <i class="fa fa-solid fa-address-card"></i>
                                            <span class="ms-0">{{ __('Informations Personnelles') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a id="medicalRecord-tab" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab"
                                           href="javascript:;" role="tab" aria-controls="teams" aria-selected="false">
                                            <i class="fa fa-solid fa-lock"></i>
                                            <span class="ms-1">{{ __('Dossier Médical') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <x-general-info :user="auth()->user()" :role="auth()->user()->role"></x-general-info>
            <x-security></x-security>
            <x-medical-record></x-medical-record>

        </div>

    <script>
        document.getElementById('profile-tab').addEventListener('click', function () {
            document.getElementById('medicalRecord-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'block';
            document.getElementById('profile-form').style.display = 'block';
        });

        document.getElementById('medicalRecord-tab').addEventListener('click', function () {
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('medicalRecord-form').style.display = 'block';
        });

    </script>
@endsection
