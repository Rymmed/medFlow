@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="card col-8">
                <div id="calendar"></div>
            </div>
            <div class="col-md-4 align-content-center">
                <div class="btn-group mb-3" role="group" aria-label="Calendar Actions">
                    <button type="button" id="create-event-btn" class="btn btn-info bg-gradient-blue"><i class="far fa-calendar-plus me-1"></i>{{__('Rendez-vous')}}</button>
                </div>
                <div id="message-container" class="mt-3 alert alert-dismissible fade show" role="alert"
                     style="display: none;">
                    <span class="alert-text text-white"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="createModalLabel">Ajouter un Rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create-event-form" method="POST" action="{{ route('myCalendar.add-appointment') }}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="patient_id" class="form-label">Patient</label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                @foreach($patients as $patient)
                                    <option
                                        value="{{$patient->id}}">{{ $patient->firstName }} {{ $patient->lastName }}</option>
                                @endforeach
                            </select>
                            @error('patient_id')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                            <a href="{{ route('doctor-patients.create') }}" target="_blank" type="button" id="new-patient-btn" class="btn btn-success"><i
                                    class="fas fa-plus"></i> {{__('Patient')}}</a>
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Date et heure de début</label>
                            <input type="datetime-local" class="form-control" id="start_date" name="start_date"
                                   required>
                            @error('start_date')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="consultation_duration" class="form-label">Durée de la consultation (min)</label>
                            <input class="form-control" type="number" id="consultation_duration"
                                   name="consultation_duration">
                            @error('consultation_duration')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="consultation_type" class="form-label">Type de consultation</label>
                            <select class="form-control" id="consultation_type" name="consultation_type" required>
                                @foreach(\App\Enums\ConsultationType::getValues() as $type)
                                    <option value="{{$type}}">{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('consultation_type')
                            <p class="text-danger text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit" class="btn bg-gradient-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Modal -->
    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="updateModalLabel">Mettre à jour le Rendez-vous</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez-vous modifier ce rendez-vous ?
                    <form id="update-event-form" method="POST"
                          action="{{ route('myCalendar.update-appointment', 'id') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="update-patient_id" class="form-label">Patient</label>
                            <input type="text" class="form-control" id="update-patient_id" name="update-patient_id"
                                   disabled>
                        </div>
                        <div class="mb-3">
                            <label for="update-start_date" class="form-label">Date et heure de début</label>
                            <input type="datetime-local" class="form-control" id="update-start_date"
                                   name="update-start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-finish_date" class="form-label">Date et heure de fin</label>
                            <input type="datetime-local" class="form-control" id="update-finish_date"
                                   name="update-finish_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-consultation_type" class="form-label">Type de consultation</label>
                            <select class="form-control" id="update-consultation_type" name="update-consultation_type"
                                    required>
                                @foreach(\App\Enums\ConsultationType::getValues() as $type)
                                    <option value="{{$type}}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary">Sauvegarder</button>
                    </form>
                    <!-- Cancel Button -->
                    Voulez-vous annuler ce rendez-vous ?
                    <a href="{{ route('myCalendar.cancel-appointment', 'id') }}" id="cancel-btn"
                       class="btn bg-gradient-secondary">Annuler</a>

                    <!-- Success/Error Message -->
                    <div id="cancel-message" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                function showMessage(message, isSuccess) {
                    const messageContainer = document.getElementById('message-container');
                    const messageText = messageContainer.querySelector('.alert-text');

                    messageText.textContent = message;
                    messageContainer.classList.remove('alert-primary', 'alert-success');
                    messageContainer.classList.add(isSuccess ? 'alert-success' : 'alert-primary');
                    messageContainer.style.display = 'block';
                }

                var calendarEl = document.getElementById('calendar');
                let currentEvent;
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'fr',
                    editable: true,
                    selectable: true,
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,timeGridWeek,dayGridMonth'
                    },
                    events: '/myCalendar/appointments',
                    eventContent: function (info) {
                        const options = {hour: 'numeric', minute: '2-digit'};
                        const formattedStartTime = info.event.start.toLocaleTimeString([], options);
                        const formattedEndTime = info.event.end.toLocaleTimeString([], options);
                        return {
                            html: `<div>${formattedStartTime} - ${formattedEndTime}<br/>${info.event.title}<br/>${info.event.extendedProps.consultation_type}</div>`
                        };
                    },
                    eventClick: function (info) {
                        currentEvent = info.event;
                        const eventId = currentEvent.id;
                        const updateForm = document.getElementById('update-event-form');
                        const route = updateForm.getAttribute('action').replace('id', eventId); // Update the route with the event ID

                        updateForm.setAttribute('action', route);

                        let start_date = new Date(currentEvent.start.getTime() - currentEvent.start.getTimezoneOffset() * 60000);
                        let finish_date = new Date(currentEvent.end.getTime() - currentEvent.end.getTimezoneOffset() * 60000);
                        document.getElementById('update-patient_id').value = currentEvent.title; // Assuming you have the patient name in extendedProps
                        document.getElementById('update-start_date').value = start_date.toISOString().slice(0, 16);
                        document.getElementById('update-finish_date').value = finish_date.toISOString().slice(0, 16); // Format datetime-local input
                        // document.getElementById('update-consultation_duration').value = currentEvent.extendedProps.consultation_duration;
                        document.getElementById('update-consultation_type').value = currentEvent.extendedProps.consultation_type;

                        $('#updateModal').modal('show');
                    },
                    eventDrop: function (info) {
                        var eventId = info.event.id;
                        var newStartDate = info.event.start;
                        var newEndDate = info.event.end;

                        $.ajax({
                            method: 'post',
                            url: `/myCalendar/drop-appointment/${eventId}`,
                            data: {
                                '_token': "{{ csrf_token() }}",
                                start_date: newStartDate.toISOString(),
                                finish_date: newEndDate ? newEndDate.toISOString() : null,
                            },
                            success: function (response) {
                                showMessage(response.message, true);
                                calendar.refetchEvents();
                            },
                            error: function (response) {
                                const errorMessage = response.responseJSON.message || 'Erreur de déplacement du rendez-vous';
                                showMessage(errorMessage, false);
                            }
                        });
                    },
                });
                calendar.render();

                document.getElementById('create-event-btn').addEventListener('click', function () {
                    $('#createModal').modal('show');
                });

                document.getElementById('create-event-form').addEventListener('submit', function (e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = form.serialize();

                    $.ajax({
                        url: '{{ route('myCalendar.add-appointment') }}',
                        method: 'POST',
                        data: formData,
                        success: function (response) {
                            showMessage(response.message, true);
                            $('#createModal').modal('hide');
                            calendar.refetchEvents();
                        },
                        error: function (response) {
                            const errorMessage = response.responseJSON.message || 'Échec de création du rendez-vous';
                            $('#createModal').modal('hide');
                            showMessage(errorMessage, false);
                        }
                    });
                });

                document.getElementById('update-event-form').addEventListener('submit', function (e) {
                    e.preventDefault();

                    let form = $(this);
                    let formData = form.serialize();

                    $.ajax({
                        url: form.attr('action'),
                        method: 'POST',
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#updateModal').modal('hide');
                            showMessage(response.message, true);
                            calendar.refetchEvents();
                        },
                        error: function (response) {
                            const errorMessage = response.responseJSON.message || 'Échec de mis à jour du rendez-vous';
                            $('#updateModal').modal('hide');
                            showMessage(errorMessage, false);
                        }
                    });
                });

                const patientSelect = document.getElementById('patient_id');
                new Choices(patientSelect, {
                    removeItemButton: true,
                    placeholderValue: 'Choisir un patient',
                    itemSelectText: 'Appuyer pour séléctionner',
                    allowHTML: true,
                });

                const cancelBtn = document.getElementById('cancel-btn');

                cancelBtn.addEventListener('click', function (e) {
                    e.preventDefault();
                    const cancelRoute = cancelBtn.getAttribute('href').replace('id', currentEvent.id);

                    $.ajax({
                        url: cancelRoute,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $('#updateModal').modal('hide');
                            showMessage(response.message, true);
                            calendar.refetchEvents();
                        },
                        error: function (response) {
                            const errorMessage = response.responseJSON.message || 'Échec d\'annulation du rendez-vous';
                            $('#updateModal').modal('hide');
                            showMessage(errorMessage, false);
                        }
                    });
                });
            });
        </script>

@endsection
