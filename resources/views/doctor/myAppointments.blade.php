@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid">
        <div class="row">
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
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Demandes de Rendez-Vous</h6>
                    </div>
                    @if($pendingAppointments->isEmpty())
                        <p class="px-3 py-3">Aucune demande de rendez-vous trouvée.</p>
                    @else
                        <div class="card-body pt-4 p-3 fixed-height-list">
                            <div class="list-group">
                                @foreach($pendingAppointments as $appointment)
                                    <div class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                        <div class="author align-items-center"
                                             @if($patients->contains('id', $appointment->patient_id))
                                                 onclick="redirectToProfile('{{ route('patient.record', ['id' => $appointment->patient_id]) }}')"
                                             @else
                                                 data-bs-toggle="modal"
                                             data-bs-target="#publicProfileModal-{{ $appointment->id }}"

                                             @endif
                                             style="cursor: pointer;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <x-profile-image
                                                        :class="'avatar avatar-xl border-radius-section shadow-sm'"
                                                        :image="$appointment->patient->profile_image"></x-profile-image>
                                                </div>
                                                <div class="col-md-8 name ps-3">
                                                    <span>{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</span>
                                                    <div class="stats">
                                                        <small>{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }}
                                                            - {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}
                                                            <br>Motif de
                                                            consultation: {{ $appointment->consultation_reason }}
                                                        </small><br>
                                                        <x-consultation-type-badge
                                                            :consultation_type="$appointment->consultation_type"></x-consultation-type-badge>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto text-end col-4">
                                            <form action="{{ route('appointments.updateStatus') }}" method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="appointment_id"
                                                       value="{{ $appointment->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{\App\Enums\AppointmentStatus::CONFIRMED}}">
                                                <button type="submit"
                                                        class="btn btn-link text-success text-gradient px-3 mb-0">
                                                    <i class="fa fa-check me-2"></i>{{ __('Confirmer') }}
                                                </button>
                                            </form>
                                            <form action="{{ route('appointments.updateStatus') }}" method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="appointment_id"
                                                       value="{{ $appointment->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{\App\Enums\AppointmentStatus::REFUSED}}">
                                                <button type="submit" class="btn btn-link text-dark px-3 mb-0">
                                                    <i class="fas fa-times text-dark me-2"></i>{{ __('Refuser') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="publicProfileModal-{{ $appointment->id }}" tabindex="-1"
                                         role="dialog"
                                         aria-labelledby="modal-notification" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Informations sur le patient</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close">
                                                    <span class="text-dark" aria-hidden="true"><i
                                                            class="fa fa-close"></i></span>
                                                    </button>
                                                </div>
                                                <div class="modal-body mx-2">
                                                    <div class="text-center">
                                                        <x-profile-image
                                                            class="avatar avatar-xl border-radius-section shadow-sm"
                                                            :image="$appointment->patient->profile_image"></x-profile-image>
                                                        <h6 class="mt-3">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>
                                                        <p class="text-secondary">
                                                            {{ \Carbon\Carbon::parse($appointment->patient->dob)->age }}
                                                            ans,
                                                            {{ $appointment->patient->gender === 0 ? 'Homme' : 'Femme' }}
                                                        </p>
                                                    </div>
                                                    <div class="row mt-4 text-center">
                                                        <div class="col-6">
                                                            <p class="text-sm text-secondary">{{ __('Adresse') }}</p>
                                                            <p class="text-dark">{{ $appointment->patient->address }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="text-sm text-secondary">{{ __('Ville') }}</p>
                                                            <p class="text-dark">{{ $appointment->patient->city }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2 text-center">
                                                        <div class="col-6">
                                                            <p class="text-sm text-secondary">{{ __('Email') }}</p>
                                                            <p class="text-dark">{{ $appointment->patient->email }}</p>
                                                        </div>
                                                        <div class="col-6">
                                                            <p class="text-sm text-secondary">{{ __('Numéro de téléphone') }}</p>
                                                            <p class="text-dark">{{ $appointment->patient->phone_number }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2 text-center">
                                                        <div class="col-6">
                                                            <p class="text-sm text-secondary">{{ __('Pays') }}</p>
                                                            <p class="text-dark">{{ $appointment->patient->country }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST" class="d-inline me-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="appointment_id"
                                                               value="{{ $appointment->id }}">
                                                        <input type="hidden" name="status"
                                                               value="{{ \App\Enums\AppointmentStatus::CONFIRMED }}">
                                                        <button type="submit" class="btn btn-success">
                                                            <i class="fa fa-check"></i> {{ __('Confirmer') }}
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="appointment_id"
                                                               value="{{ $appointment->id }}">
                                                        <input type="hidden" name="status"
                                                               value="{{ \App\Enums\AppointmentStatus::REFUSED }}">
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-times"></i> {{ __('Refuser') }}
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Fermer
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card">
                    <div class="card-header pb-0 px-3">
                        <h6 class="mb-0">Liste de Rendez-Vous Confirmé</h6>
                    </div>
                    @if($confirmedAppointments->isEmpty())
                        <p class="px-3 py-3">Aucun rendez-vous trouvé.</p>
                    @else
                        <div class="card-body pt-4 p-3 fixed-height-list">
                            <div class="list-group">
                                @foreach($confirmedAppointments as $appointment)
                                    <div class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 ">
                                        <div class="author align-items-center"
                                             onclick="redirectToProfile('{{ route('patient.record', ['patient_id' => $appointment->patient_id, 'appointment_id' => $appointment->id]) }}')"
                                             style="cursor: pointer;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    @if($appointment->patient->profile_image)
                                                        <x-profile-image
                                                            :class="'avatar avatar-xl border-radius-section shadow-sm'"
                                                            :image="$appointment->patient->profile_image"></x-profile-image>
                                                        {{--                                                        <img--}}
                                                        {{--                                                            src="{{ asset('storage/' . $appointment->patient->profile_image) }}"--}}
                                                        {{--                                                            alt="Profile image"--}}
                                                        {{--                                                            class="avatar avatar-xl border-radius-section shadow-sm">--}}
                                                    @else
                                                        <img src="{{ asset('assets/img/default-profile.jpg') }}"
                                                             alt="Default Profile image"
                                                             class="avatar avatar-xl border-radius-section shadow-sm">
                                                    @endif
                                                </div>
                                                <div class="col-md-8 name ps-3">
                                                    <span>{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</span>
                                                    <div class="stats">
                                                        <small>{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }}
                                                            - {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}
                                                            <br>Motif de
                                                            consultation: {{ $appointment->consultation_reason }}
                                                        </small><br>
                                                        <x-consultation-type-badge
                                                            :consultation_type="$appointment->consultation_type"></x-consultation-type-badge>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ms-auto text-end">
                                            <form action="{{ route('appointments.updateStatus') }}" method="POST"
                                                  class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="appointment_id"
                                                       value="{{ $appointment->id }}">
                                                <input type="hidden" name="status"
                                                       value="{{\App\Enums\AppointmentStatus::CANCELLED}}">
                                                <button type="submit" class="btn btn-link text-dark px-3 mb-0">
                                                    <i class="fas fa-times text-dark me-2"></i>{{ __('Annuler') }}
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script>
        function redirectToProfile(url) {
            window.location.href = url;
        }
        {{--$(document).ready(function() {--}}
        {{--    $('.update-status').click(function() {--}}
        {{--        var button = $(this);--}}
        {{--        var appointmentId = button.data('id');--}}
        {{--        var status = button.data('status');--}}

        {{--        $.ajax({--}}
        {{--            url: '{{ route('appointments.updateStatus') }}',--}}
        {{--            type: 'POST',--}}
        {{--            data: {--}}
        {{--                _token: '{{ csrf_token() }}',--}}
        {{--                id: appointmentId,--}}
        {{--                status: status--}}
        {{--            },--}}

        {{--            success: function(response) {--}}
        {{--                if (response.success) {--}}
        {{--                    $('#appointment-' + appointmentId + ' .status').text(response.status);--}}

        {{--                    // Désactiver les boutons si nécessaire--}}
        {{--                    if (response.status === 'confirmed' || response.status === 'refused') {--}}
        {{--                        $('#appointment-' + appointmentId + ' .update-status').prop('disabled', true);--}}
        {{--                    }--}}
        {{--                } else {--}}
        {{--                    alert('Erreur lors de la mise à jour de l\'état.');--}}
        {{--                }--}}
        {{--            },--}}
        {{--            error: function() {--}}
        {{--                alert('Erreur lors de la requête.');--}}
        {{--            }--}}
        {{--        });--}}
        {{--    });--}}
        {{--});--}}
    </script>

@endsection
