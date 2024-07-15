@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="btn-group mb-3" role="group" aria-label="Calendar Actions">
                    <button type="button" id="create-event-btn" class="btn btn-success">{{__('Ajouter')}}</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="card col-10">
                <div id="calendar"></div>
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
                            <select class="form-control" id="patient_id" name="patient_id" aria-label="patient_id"
                                    required>
                                @foreach($patients as $patient)
                                    <option
                                        value="{{ $patient->id }}">{{ $patient->firstName }} {{ $patient->lastName }}</option>
                                @endforeach
                            </select>
                            <button type="button" id="new-patient-btn" class="btn btn-success"><i
                                    class="fas fa-plus"></i> {{__('Patient')}}</button>
                        </div>
                        <div class="mb-3 d-none" id="new-patient-fields-firstName">
                            <label for="new-patient-firstName" class="form-label">Prénom du patient</label>
                            <input type="text" class="form-control" id="new-patient-firstName"
                                   name="new_patient_firstName">
                        </div>
                        <div class="mb-3 d-none" id="new-patient-fields-lastName">
                            <label for="new-patient-lastName" class="form-label">Nom du patient</label>
                            <input type="text" class="form-control" id="new-patient-lastName"
                                   name="new_patient_lastName">
                        </div>
                        <div class="mb-3">
                            <label for="start_date" class="form-label">Date et heure de début</label>
                            <input type="datetime-local" class="form-control" id="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="consultation_duration" class="form-label">Durée de la consultation</label>
                            <input class="form-control" type="number" id="consultation_duration"
                                   name="consultation_duration">
                        </div>
                        <div class="mb-3">
                            <label for="consultation_type" class="form-label">Type de consultation</label>
                            <select type="datetime-local" class="form-control" id="consultation_type" required>
                                <option value="Online">{{ __('En ligne') }}</option>
                                <option value="In person">{{ __('En présentiel') }}</option>
                                <option value="Home service">{{ __('Service à domicile') }}</option>
                            </select>
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
                          action="{{ route('myCalendar.update-appointment', '') }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="update-patient_id" class="form-label">Patient</label>
                            <input type="text" class="form-control" id="update-patient_id"
                                   name="update-patient_id" value required>
                        </div>
                        <div class="mb-3">
                            <label for="update-start_date" class="form-label">Date et heure de début</label>
                            <input type="datetime-local" class="form-control" id="update-start_date"
                                   name="update-start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="update-consultation_duration" class="form-label">Durée de consultation</label>
                            <input type="number" class="form-control" id="update-consultation_duration"
                                   name="update-consultation_duration">
                        </div>
                        <div class="mb-3">
                            <label for="update-consultation_type" class="form-label">Type de consultation</label>
                            <select type="datetime-local" class="form-control" id="update-consultation_type"
                                    name="update-consultation_type" required>
                                <option value="Online">{{ __('En ligne') }}</option>
                                <option value="In person">{{ __('En présentiel') }}</option>
                                <option value="Home service">{{ __('Service à domicile') }}</option>
                            </select>
                        </div>
                        <button type="submit" class="btn bg-gradient-primary">Sauvegarder</button>
                    </form>
                    Voulez-vous annuler ce rendez-vous ?
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function () {
                var events = [];
                var calendarEl = document.getElementById('calendar');
                let currentEvent;
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    locale: 'fr',
                    editable: true,
                    selectable: true,
                    droppable: true,
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'timeGridDay,timeGridWeek,dayGridMonth'
                    },

                    events: '/myCalendar/appointments',

                    eventContent: function (info) {
                        return {
                            html: info.event.start.toLocaleTimeString() + '<br/>' + info.event.extendedProps.consultation_type
                        };
                    },
                    eventClick: function (info) {
                        currentEvent = info.event;
                        const eventId = currentEvent.id;
                        const updateForm = document.getElementById('update-event-form');
                        const route = updateForm.getAttribute('action');

                        updateForm.setAttribute('action', `${route}/${eventId}`);

                        $('#updateModal').modal('show');
                    },
                    // Deleting the event
                    // eventClick: function (info){
                    //     if(confirm("Voulez-vous vraiment annuler ce rendez-vous ?")) {
                    //         var eventId = info.event.id;
                    //         $.ajax({
                    //             method: 'post',
                    //             url: '/myCalendar/appointment/' + eventId,
                    //             headers: {
                    //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    //             },
                    //             success: function(response) {
                    //                 console.log('Rendez-vous annulé avec succès.');
                    //                 calendar.refetchEvents(); // Refresh events after deletion
                    //             },
                    //             error: function(error) {
                    //                 console.error('Erreur d\'annulation du rendez-vous:', error);
                    //             }
                    //         });
                    //     }
                    // },

                    // Drag And Drop
                    eventDrop: function (info) {
                        var eventId = info.event.id;
                        var newStartDate = info.event.start;
                        var newEndDate = info.event.end;

                        $.ajax({
                            method: 'post',
                            url: `/myCalendar/update-appointment/${eventId}`,
                            data: {
                                '_token': "{{ csrf_token() }}",
                                start_date: newStartDate.toISOString(),
                                finish_date: newEndDate.toISOString(),
                            },
                            success: function () {
                                console.log('Rendez-vous déplacé avec succès.');
                                calendar.refetchEvents();
                            },
                            error: function (error) {
                                console.error('Erreur de déplacement du rendez-vous', error)
                            }
                        });
                    },
                });
                calendar.render();
                document.getElementById('create-event-btn').addEventListener('click', function () {
                    $('#createModal').modal('show');
                })
                document.getElementById('create-event-form').addEventListener('submit', function () {
                    e.preventDefault();
                    let data = $(this).serialize();

                    $.ajax({
                        url: '{{ route('myCalendar.add-appointment') }}',
                        method: 'POST',
                        data: data,
                        success: function (response) {
                            if (response.success) {
                                calendar.refetchEvents();
                                alert('Rendez-vous créé avec succès');
                                $('#createModal').modal('hide');
                            } else {
                                alert('Échec de la création du rendez-vous');
                            }
                        },
                        error: function (error) {
                            console.error('Erreur lors de la création du rendez-vous:', error);
                            alert('Erreur lors de la création du rendez-vous');
                        }
                    });
                })

                document.getElementById('update-event-form').addEventListener('submit', function (e) {
                    e.preventDefault();
                    currentEvent.setProp('title', document.getElementById('patient_id').value);
                    currentEvent.setStart(document.getElementById('start_date').value);
                    currentEvent.setEnd(document.getElementById('finish_date').value);
                    currentEvent.setProp('consultation_type', document.getElementById('consultation_type').value);
                    updateEvent(currentEvent);
                    $('#updateModal').modal('hide');
                });
                document.addEventListener('DOMContentLoaded', function () {
                    const patientSelect = document.getElementById('patient_id');
                    const choices = new Choices(patientSelect, {
                        removeItemButton: true,
                        placeholder: true,
                        placeholderValue: 'Choisir un patient',
                        itemSelectText: 'Appuyer pour séléctionner',
                        allowHTML: true,
                    });
                });
                document.getElementById('new-patient-btn').addEventListener('click', function () {
                    document.getElementById('new-patient-fields-lastName').classList.remove('d-none');
                    document.getElementById('new-patient-fields-firstName').classList.remove('d-none');
                    document.getElementById('new-patient-lastName').setAttribute('required', 'required');
                    document.getElementById('new-patient-firstName').setAttribute('required', 'required');
                });


                function updateEvent(event) {
                    let data = {
                        id: event.id,
                        title: event.title,
                        start: event.start.toISOString(),
                        end: event.end ? event.end.toISOString() : null
                    };

                    $.ajax({
                        url: '{{ route('myCalendar.update-appointment', '') }}',
                        method: 'POST',
                        data: data,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Rendez-vous mis à jour avec succès');
                            } else {
                                alert('Échec de la mise à jour du rendez-vous');
                            }
                        },
                        error: function (error) {
                            console.error('Erreur lors de la mise à jour du rendez-vous:', error);
                            alert('Erreur lors de la mise à jour du rendez-vous');
                        }
                    });
                }

                function createEvent(start, end) {
                    let title = prompt('Entrez le titre de l\'événement:');
                    if (title) {
                        let data = {
                            title: title,
                            start: start,
                            end: end,
                            consultation_type: 'En ligne'
                        };

                        $.ajax({
                            url: '{{ route('myCalendar.add-appointment', '') }}',
                            method: 'POST',
                            data: data,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                if (response.success) {
                                    calendar.addEvent(response.event);
                                    alert('Rendez-vous créé avec succès');
                                } else {
                                    alert('Échec de la création du rendez-vous');
                                }
                            },
                            error: function (error) {
                                console.error('Erreur lors de la création du rendez-vous:', error);
                                alert('Erreur lors de la création du rendez-vous');
                            }
                        });
                    }
                }

            })

        </script>
    @endpush
@endsection


