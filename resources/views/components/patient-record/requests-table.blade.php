@props(['appointments'])
<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Médecin</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Type</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Heure</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td class="text-start">
                    <div class="d-flex px-2 py-1">
                        <div class="me-2">
                            <x-profile-image :class="'avatar avatar-sm shadow-sm'"
                                             :image="$appointment->doctor->profile_image"></x-profile-image>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-xs">
                                Dr. {{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $appointment->doctor->doctor_info->speciality }}</p>
                        </div>
                    </div>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">
                        <x-consultation-type-badge
                            :consultation_type="$appointment->consultation_type"></x-consultation-type-badge>
                    </p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('d M, Y') }}</p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}</p>
                </td>
                <td class="text-center">
                    @if(!in_array($appointment->status, [\App\Enums\AppointmentStatus::REFUSED, \App\Enums\AppointmentStatus::CANCELLED]))
                        <!-- Action Icons -->
                        <div class="d-flex justify-content-center">
                            <!-- Reschedule Icon -->
                            <a class="text-blue me-3" type="button" data-bs-toggle="modal"
                               data-bs-target="#rescheduleModal-{{ $appointment->id }}">
                                <i class="fas fa-calendar-alt"></i>
                            </a>

                            <!-- Cancel Icon -->
                            <a class="text-primary" type="button" data-bs-toggle="modal"
                               data-bs-target="#cancelModal-{{ $appointment->id }}">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @else
                        <!-- Disabled Action Icons -->
                        <div class="d-flex justify-content-center">
                            <!-- Reschedule Icon (Disabled) -->
                            <a class="text-muted me-3" type="button" style="pointer-events: none; cursor: default;">
                                <i class="fas fa-calendar-alt"></i>
                            </a>

                            <!-- Cancel Icon (Disabled) -->
                            <a class="text-muted" type="button" style="pointer-events: none; cursor: default;">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    @endif
                    <!-- Reschedule Modal -->
                    <div class="modal fade" id="rescheduleModal-{{ $appointment->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="rescheduleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="rescheduleModalLabel">Reporter le Rendez-vous</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        action="{{ route('appointment.RescheduleOrCancel', ['appointment_id' => $appointment->id]) }}"
                                        method="POST">
                                        @csrf

                                        <input type="hidden" name="action" value="reschedule">
                                        <div class="form-group mb-3">
                                            <label for="new_date-{{ $appointment->id }}">Nouvelle Date</label>
                                            <input type="datetime-local" name="new_date" id="new_date-{{ $appointment->id }}"
                                                   class="form-control" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Annuler
                                            </button>
                                            <button type="submit" class="btn btn-primary">Envoyer la Demande</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Modal -->
                    <div class="modal fade" id="cancelModal-{{ $appointment->id }}" tabindex="-1" role="dialog"
                         aria-labelledby="cancelModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cancelModalLabel">Annuler le Rendez-vous</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Êtes-vous sûr de vouloir annuler ce rendez-vous ?</p>
                                </div>
                                <div class="modal-footer">
                                    <form
                                        action="{{ route('appointment.RescheduleOrCancel', ['appointment_id' => $appointment->id]) }}"
                                        method="POST">
                                        @csrf
                                        <input type="hidden" name="action" value="cancel">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Non
                                        </button>
                                        <button type="submit" class="btn btn-danger">Oui, Annuler</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
