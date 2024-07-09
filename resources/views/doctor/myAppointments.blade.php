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
                        <div class="card-body pt-4 p-3 appointments-list">
                            <ul class="list-group">
                                @foreach($pendingAppointments as $appointment)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="author align-items-center">
                                        <img src="./assets/img/kit/pro/team-2.jpg" alt="..." class="avatar shadow">
                                        <div class="name ps-3">
                                            <span>Mathew Glock</span>
                                            <div class="stats">
                                                <small>Posted on 28 February</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column col-8" id="appointment-{{ $appointment->id }}">
                                        <h6 class="mb-3 text-sm">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>
                                        <span class="mb-2 text-xs">Date: <span class="text-dark font-weight-bold ms-sm-2">{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }}</span></span>
                                        <span class="mb-2 text-xs">Heure: <span class="text-dark ms-sm-2 font-weight-bold">{{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}</span></span>
                                        <span class="mb-2 text-xs">Motif de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_reason }}</span></span>
                                        <span class="text-xs">Type de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_type }}</span></span>
                                    </div>
                                    <div class="ms-auto text-end col-4">
                                        <form action="{{ route('appointments.updateStatus') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-link text-success text-gradient px-3 mb-0">
                                                <i class="fa fa-check me-2"></i>{{ __('Confirmer') }}
                                            </button>
                                        </form>
                                        <form action="{{ route('appointments.updateStatus') }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                            <input type="hidden" name="status" value="refused">
                                            <button type="submit" class="btn btn-link text-dark px-3 mb-0">
                                                <i class="fas fa-times text-dark me-2"></i>{{ __('Refuser') }}
                                            </button>
                                        </form>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
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
                            <div class="card-body pt-4 p-3 appointments-list">
                                <div class="list-group">
                                    @foreach($confirmedAppointments as $appointment)
                                            <div class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 ">
                                                <div class="author align-items-center">
                                                    <div class="row">
                                                        <div class="col-4">
                                                            @if($appointment->patient->profile_image)
                                                                <img src="{{ asset('storage/' . $appointment->patient->profile_image) }}" alt="Profile image"
                                                                     class="avatar avatar-xl border-radius-section shadow-sm">
                                                            @else
                                                                <img src="{{ asset('assets/img/default-profile.jpg') }}" alt="Default Profile image"
                                                                     class="avatar avatar-xl border-radius-section shadow-sm">
                                                            @endif
                                                        </div>
                                                        <div class="col-8 name ps-3">
                                                            <span>{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</span>
                                                            <div class="stats">
                                                                <small>{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}<br>Motif de consultation: {{ $appointment->consultation_reason }}</small><br>
                                                                <x-consultation-type-badge :consultation_type="$appointment->consultation_type"></x-consultation-type-badge>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
{{--                                                <div class="d-flex flex-column col-8" id="appointment-{{ $appointment->id }}">--}}
{{--                                                    <h6 class="mb-3 text-sm">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>--}}
{{--                                                    <span class="mb-2 text-xs">Date: <span class="text-dark font-weight-bold ms-sm-2">{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }}</span></span>--}}
{{--                                                    <span class="mb-2 text-xs">Heure: <span class="text-dark ms-sm-2 font-weight-bold">{{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}</span></span>--}}
{{--                                                    <span class="mb-2 text-xs">Motif de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_reason }}</span></span>--}}
{{--                                                    <span class="text-xs">Type de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_type }}</span></span>--}}
{{--                                                </div>--}}
                                                <div class="ms-auto text-end">
                                                    <form action="{{ route('appointments.updateStatus') }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="appointment_id" value="{{ $appointment->id }}">
                                                        <input type="hidden" name="status" value="cancelled">
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
