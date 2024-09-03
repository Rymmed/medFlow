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
            <div class="col-md-12 mt-4">
                <!-- Onglets -->
                <ul class="nav nav-tabs" id="appointmentTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                data-bs-target="#pending" type="button" role="tab" aria-controls="pending"
                                aria-selected="true">
                            Demandes de Rendez-Vous
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="reschedule-tab" data-bs-toggle="tab" data-bs-target="#reschedule"
                                type="button" role="tab" aria-controls="reschedule" aria-selected="false">
                            Demandes de Replanification
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="confirmed-tab" data-bs-toggle="tab" data-bs-target="#confirmed"
                                type="button" role="tab" aria-controls="confirmed" aria-selected="false">
                            Confirmés
                        </button>
                    </li>
                </ul>

                <!-- Contenu des onglets -->
                <div class="tab-content" id="appointmentTabsContent">
                    <!-- Onglet "Demandes de Rendez-Vous" -->
                    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                        <div class="card mt-3">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">Demandes de Rendez-Vous</h6>
                            </div>
                            @if($pendingAppointments->isEmpty())
                                <p class="px-3 py-3">Aucune demande de rendez-vous trouvée.</p>
                            @else
                                <div class="card-body pt-4 p-3 fixed-height-list">
                                    <div class="list-group">
                                        <!-- Contenu de la liste des demandes de rendez-vous -->
                                        @foreach($pendingAppointments as $appointment)
                                            <div
                                                class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="author align-items-center"
                                                     @if($patients->contains('id', $appointment->patient_id) && auth()->user()->role === 'doctor')
                                                         onclick="redirectToProfile('{{ route('patient.record', ['patient_id' => $appointment->patient_id, 'appointment_id' => $appointment->id]) }}')"
                                                     @else
                                                         data-bs-toggle="modal"
                                                     data-bs-target="#publicProfileModal-{{ $appointment->id }}"

                                                     @endif
                                                     style="cursor: pointer;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <x-profile-image
                                                                :class="'avatar avatar-xl border-radius-section shadow-sm me-5'"
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
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST"
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
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST"
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
                                            <x-public-profile-modal :appointment="$appointment"/>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Onglet "Demandes de Replanification" -->
                    <div class="tab-pane fade" id="reschedule" role="tabpanel" aria-labelledby="reschedule-tab">
                        <div class="card mt-3">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">Demandes de Replanification</h6>
                            </div>
                            @if($rescheduleAppointments->isEmpty())
                                <p class="px-3 py-3">Aucune demande de replanification trouvée.</p>
                            @else
                                <div class="card-body pt-4 p-3 fixed-height-list">
                                    <div class="list-group">
                                        <!-- Contenu de la liste des demandes de replanification -->
                                        @foreach($rescheduleAppointments as $appointment)
                                            <div
                                                class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 border-radius-lg">
                                                <div class="author align-items-center"
                                                     @if($patients->contains('id', $appointment->patient_id) && auth()->user()->role === 'doctor')
                                                         onclick="redirectToProfile('{{ route('patient.record', ['patient_id' => $appointment->patient_id, 'appointment_id' => $appointment->id]) }}')"
                                                     @else
                                                         data-bs-toggle="modal"
                                                     data-bs-target="#publicProfileModal-{{ $appointment->id }}"
                                                     @endif
                                                     style="cursor: pointer;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <x-profile-image
                                                                :class="'avatar avatar-xl border-radius-section shadow-sm me-5'"
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
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST"
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
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST"
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
                                            <x-public-profile-modal :appointment="$appointment"/>

                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- Onglet "Rendez-Vous Confirmés" -->
                    <div class="tab-pane fade" id="confirmed" role="tabpanel"
                         aria-labelledby="confirmed-tab">
                        <div class="card mt-3">
                            <div class="card-header pb-0 px-3">
                                <h6 class="mb-0">Rendez-Vous Confirmés</h6>
                            </div>
                            @if($confirmedAppointments->isEmpty())
                                <p class="px-3 py-3">Aucun rendez-vous trouvé.</p>
                            @else
                                <div class="card-body pt-4 p-3 fixed-height-list">
                                    <div class="list-group">
                                        @foreach($confirmedAppointments as $appointment)
                                            <div class="list-group-item border-0 d-flex p-4 mb-2 bg-gray-100 ">
                                                <div class="author align-items-center"
                                                     @if( auth()->user()->role === 'doctor')
                                                         onclick="redirectToProfile('{{ route('patient.record', ['patient_id' => $appointment->patient_id, 'appointment_id' => $appointment->id]) }}')"
                                                     @else
                                                         data-bs-toggle="modal"
                                                     data-bs-target="#publicProfileModal-{{ $appointment->id }}"
                                                     @endif
                                                     style="cursor: pointer;">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <x-profile-image
                                                                :class="'avatar avatar-xl border-radius-section shadow-sm me-5'"
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
                                                <div class="ms-auto text-end">
                                                    <form action="{{ route('appointments.updateStatus') }}"
                                                          method="POST"
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="appointment_id"
                                                               value="{{ $appointment->id }}">
                                                        <input type="hidden" name="status"
                                                               value="{{\App\Enums\AppointmentStatus::CANCELLED}}">
                                                        <button type="submit"
                                                                class="btn btn-link text-primary text-bold px-3 mb-0">
                                                            <i class="fas fa-times  me-2"></i>{{ __('Annuler') }}
                                                        </button>
                                                    </form>
                                                    <button type="button"
                                                            class="btn btn-link text-info text-bold px-3 mb-0"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#updateModal-{{ $appointment->id }}">
                                                        <i class="fas fa-calendar me-2"></i>{{ __('Reporter') }}
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="updateModal-{{ $appointment->id }}"
                                                 tabindex="-1"
                                                 role="dialog" aria-labelledby="updateModalLabel-{{ $appointment->id }}"
                                                 aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title font-weight-normal"
                                                                id="updateModalLabel-{{ $appointment->id }}">Mettre à
                                                                jour le
                                                                Rendez-vous</h5>
                                                            <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"
                                                                    aria-label="Close">
                                                        <span class="text-dark" aria-hidden="true"><i
                                                                class="fa fa-close"></i></span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="update-event-form-{{ $appointment->id }}"
                                                                  method="POST"
                                                                  action="{{ route('appointments.update-appointment', ['id' =>$appointment->id] ) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="update-patient_id-{{ $appointment->id }}"
                                                                        class="form-label">Patient</label>
                                                                    <input type="text" class="form-control"
                                                                           id="update-patient_id-{{ $appointment->id }}"
                                                                           name="update-patient_id"
                                                                           value="{{$appointment->patient->firstName}} {{$appointment->patient->lastName}}"
                                                                           disabled>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="update-start_date-{{ $appointment->id }}"
                                                                        class="form-label">Date et heure de
                                                                        début</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                           id="update-start_date-{{ $appointment->id }}"
                                                                           name="update-start_date"
                                                                           value="{{$appointment->start_date}}"
                                                                           required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="update-finish_date-{{ $appointment->id }}"
                                                                        class="form-label">Date et heure de fin</label>
                                                                    <input type="datetime-local" class="form-control"
                                                                           id="update-finish_date-{{ $appointment->id }}"
                                                                           name="update-finish_date"
                                                                           value="{{$appointment->finish_date}}"
                                                                           required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        for="update-consultation_type-{{ $appointment->id }}"
                                                                        class="form-label">Type de consultation</label>
                                                                    <select class="form-control"
                                                                            id="update-consultation_type-{{ $appointment->id }}"
                                                                            name="update-consultation_type"
                                                                            required>
                                                                        <option
                                                                            value="{{$appointment->consultation_type}}"
                                                                            selected>{{$appointment->consultation_type}}</option>
                                                                        @foreach(\App\Enums\ConsultationType::getValues() as $type)
                                                                            <option
                                                                                value="{{$type}}">{{ $type }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn bg-gradient-primary">
                                                                    Sauvegarder
                                                                </button>
                                                            </form>
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
                </div>
            </div>
        </div>
    </div>
    <script>
        function redirectToProfile(url) {
            window.location.href = url;
        }
    </script>

@endsection
