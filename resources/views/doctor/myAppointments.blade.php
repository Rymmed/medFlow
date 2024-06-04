@extends('layouts.user_type.auth')

@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mt-4">
                    <div class="card">
                        <div class="card-header pb-0 px-3">
                            <h6 class="mb-0">Demande de Rendez-Vous</h6>
                        </div>
                        @if($pendingAppointments->isEmpty())
                            <p class="px-3 py-3">Aucune demande de rendez-vous trouvée.</p>
                        @else
                        <div class="card-body pt-4 p-3">
                            <ul class="list-group">
                                @foreach($pendingAppointments as $appointment)
                                <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                    <div class="d-flex flex-column col-8" id="appointment-{{ $appointment->id }}">
                                        <h6 class="mb-3 text-sm">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>
                                        <span class="mb-2 text-xs">Date: <span class="text-dark font-weight-bold ms-sm-2">{{ $appointment->date }}</span></span>
                                        <span class="mb-2 text-xs">Heure: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->time }}</span></span>
                                        <span class="mb-2 text-xs">Motif de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_reason }}</span></span>
                                        <span class="text-xs">Type de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_type }}</span></span>
                                    </div>
                                    <div class="ms-auto text-end col-4">
                                            <button class="btn btn-link text-success text-gradient px-3 mb-0 update-status" data-id="{{ $appointment->id }}" data-status="confirmed">
                                                <i class="fa fa-check me-2"></i>{{ __('Confirmer') }}
                                            </button>
                                            <button class="btn btn-link text-dark px-3 mb-0 update-status" data-id="{{ $appointment->id }}" data-status="cancelled">
                                                <i class="fas fa-times text-dark me-2"></i>{{ __('Refuser') }}
                                            </button>
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
                            <div class="card-body pt-4 p-3">
                                <ul class="list-group">
                                    @foreach($confirmedAppointments as $appointment)
                                            <li class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="d-flex flex-column col-8" id="appointment-{{ $appointment->id }}">
                                                    <h6 class="mb-3 text-sm">{{ $appointment->patient->firstName }} {{ $appointment->patient->lastName }}</h6>
                                                    <span class="mb-2 text-xs">Date: <span class="text-dark font-weight-bold ms-sm-2">{{ $appointment->date }}</span></span>
                                                    <span class="mb-2 text-xs">Heure: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->time }}</span></span>
                                                    <span class="mb-2 text-xs">Motif de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_reason }}</span></span>
                                                    <span class="text-xs">Type de Consultation: <span class="text-dark ms-sm-2 font-weight-bold">{{ $appointment->consultation_type }}</span></span>
                                                </div>
                                                <div class="ms-auto text-end col-4">
                                                    <button class="btn btn-link text-dark px-3 mb-0 update-status" data-id="{{ $appointment->id }}" data-status="cancelled">
                                                        <i class="fas fa-times text-dark me-2"></i>{{ __('Annuler') }}
                                                    </button>
                                                </div>
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('.update-status').click(function() {
                    var button = $(this);
                    var appointmentId = button.data('id');
                    var status = button.data('status');

                    $.ajax({
                        url: '{{ route('appointments.updateStatus') }}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: appointmentId,
                            status: status
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#appointment-' + appointmentId + ' .status').text(response.status);

                                // Désactiver les boutons si nécessaire
                                if (response.status === 'confirmed' || response.status === 'cancelled') {
                                    $('#appointment-' + appointmentId + ' .update-status').prop('disabled', true);
                                }
                            } else {
                                alert('Erreur lors de la mise à jour de l\'état.');
                            }
                        },
                        error: function() {
                            alert('Erreur lors de la requête.');
                        }
                    });
                });
            });
        </script>

@endsection
