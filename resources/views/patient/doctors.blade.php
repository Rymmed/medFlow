@extends('layouts.user_type.auth')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Mes Médecins</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
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
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                            <tr>
                                <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Médecin
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Email
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    N° téléphone
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Sexe
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Dernier Rendez-vous
                                </th>
                                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Action
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($doctors as $doctor)
                                <tr>
                                    <td class="text-start">
                                        <div class="d-flex px-2 py-1">
                                            <div class="me-2">
                                                <x-profile-image :class="'avatar avatar-sm shadow-sm'" :image="$doctor->profile_image"></x-profile-image>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-xs">Dr. {{ $doctor->lastName }} {{ $doctor->firstName }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $doctor->doctor_info->speciality }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $doctor->email }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $doctor->phone_number ? : '---' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">@if($doctor->gender === 0)
                                                {{ __('Homme') }}
                                            @else
                                                {{ __('Femme') }}
                                            @endif</p>
                                    </td>
                                    <td class="text-center">
                                        @if($doctor->doctorAppointments->isNotEmpty())
                                        <p class="text-xs font-weight-bold mb-0">{{ $doctor->doctorAppointments->first()->start_date }}</p>
                                        @else
                                            <p class="text-xs font-weight-bold mb-0">---</p>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('appointment.request', ['doctor_id' => $doctor->id]) }}"
                                           class="text-primary"><i class="far fa-calendar-plus me-1"></i></a>
                                        <a href="{{ route('feedback.create', ['doctor_id' => $doctor->id]) }}"
                                           class="text-blue"><i class="fa-regular fa-star me-1"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
