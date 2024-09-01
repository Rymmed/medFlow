@extends('layouts.user_type.auth')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 text-center">
                <x-patient-record.profile-card :user="$patient"
                                               :appointment="auth()->user()->role === 'doctor' ? $appointment : null"></x-patient-record.profile-card>
                <ul class="list-group card my-3">
                    <li class="list-group-item border-0" onclick="showSection('generalInfo')">Informations Générales
                    </li>
                    <li class="list-group-item border-0" onclick="showSection('medicalHistory')">Antécédents
                        Médicales
                    </li>
                    <li class="list-group-item border-0" onclick="showSection('vaccinations')">Vaccinations</li>
                    <li class="list-group-item border-0" onclick="showSection('vitalSigns')">Signes Vitaux</li>
                    <li class="list-group-item border-0" onclick="showSection('examResults')">Bilan Médicaux</li>
                    @if(auth()->user()->role === 'doctor')
                        <li class="list-group-item border-0" onclick="showSection('consultationReports')">Rapports de
                            Consultations
                        </li>
                        <li class="list-group-item border-0" onclick="showSection('appointmentHistory')">Historique de
                            Rendez-vous
                        </li>
                    @endif
                    @if(auth()->user()->role === 'patient')
                        <li class="list-group-item border-0" onclick="showSection('security')">Sécurité</li>
                    @endif

                </ul>
            </div>
            <div class="col-md-9">
                <div class="container-fluid">
                    @if(auth()->user()->role === 'doctor')
                    <div class="btn-group mb-3" role="group" aria-label="Calendar Actions">
                        <button type="button" id="create-event-btn" class="btn btn-info bg-gradient-blue"><i
                                class="far fa-calendar-plus me-1"></i>{{__('Rendez-Vous')}}</button>
                    </div>
                    @endif
                    <div id="message-container" class="mt-3 alert alert-dismissible fade show" role="alert"
                         style="display: none;">
                        <span class="alert-text text-white"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fa fa-close" aria-hidden="true"></i>
                        </button>
                    </div>
                    <!-- Content Area -->
                    <div id="generalInfo" class="section card active">
                        <x-patient-record.general-info :patient="$patient"
                                                       :medicalRecord="$medicalRecord"></x-patient-record.general-info>
                    </div>

                    <div id="medicalHistory" class="section card">
                        <x-patient-record.medical-histories :medicalRecord="$medicalRecord"
                                                            :familialMedical="$familialMedicalHistories"
                                                            :familialSurgical="$familialSurgicalHistories"
                                                            :personalMedical="$personalMedicalHistories"
                                                            :personalSurgical="$personalSurgicalHistories">
                        </x-patient-record.medical-histories>
                    </div>

                    <div id="vaccinations" class="section">
                        <x-patient-record.profile-vaccinations :vaccinations="$medicalRecord->vaccinations"
                                                               :medicalRecord="$medicalRecord"></x-patient-record.profile-vaccinations>

                    </div>
                    <div id="vitalSigns" class="section card">
                        <x-patient-record.profile-vital-signs
                            :medicalRecord="$medicalRecord"></x-patient-record.profile-vital-signs>

                    </div>
                    <div id="examResults" class="section">
                        <x-patient-record.exams-results
                            :examResults="$medicalRecord->examResults"
                            :medicalRecord="$medicalRecord"></x-patient-record.exams-results>

                    </div>
                    @if(auth()->user()->role === 'doctor')
                        <div id="consultationReports" class="section card">
                            <x-patient-record.full-consultations-reports
                                :consultationReports="$consultationReports"
                                :patient="$patient"></x-patient-record.full-consultations-reports>
                        </div>
                        <div id="appointmentHistory" class="section card">
                            <div class="row">
                                <!-- Appointments -->
                                <div class="col-md-12 card">
                                    <div class="card-header pb-0">
                                        <div class="d-flex flex-row justify-content-between">
                                            <div>
                                                <h5 class="mb-0">Rendez-Vous</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <x-patient-record.appointments-list :appointments="$appointments"
                                                                        :upcomingAppointments="$upcomingAppointments"
                                                                        :recentAppointments="$recentAppointments"></x-patient-record.appointments-list>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div id="security" class="section">
                        <x-security></x-security>
                    </div>
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
                        <input class="form-control" id="patient_id" name="patient_id" value="{{$patient->id}}" hidden
                               required>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Retrieve the last section from local storage, or default to 'generalInfo'
            const lastSection = localStorage.getItem('lastSection') || 'generalInfo';

            // Show the last section or default section
            showSection(lastSection);

            // Function to display messages
            function showMessage(message, isSuccess) {
                const messageContainer = document.getElementById('message-container');
                const messageText = messageContainer.querySelector('.alert-text');

                messageText.textContent = message;
                messageContainer.classList.remove('alert-primary', 'alert-success');
                messageContainer.classList.add(isSuccess ? 'alert-success' : 'alert-primary');
                messageContainer.style.display = 'block';
            }
        });

        function showSection(sectionId) {
            // Hide all sections
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
            // Update the active class in the sidebar
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`.list-group-item[onclick="showSection('${sectionId}')"]`).classList.add('active');

            // Save the selected section in local storage
            localStorage.setItem('lastSection', sectionId);
        }

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
                },
                error: function (response) {
                    const errorMessage = response.responseJSON.message || 'Échec de création du rendez-vous';
                    $('#createModal').modal('hide');
                    showMessage(errorMessage, false);
                }
            });
        });
    </script>
@endsection
