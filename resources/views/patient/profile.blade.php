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
                    <li class="list-group-item border-0" onclick="showSection('consultationReports')">Rapports de
                        Consultations
                    </li>
                    <li class="list-group-item border-0" onclick="showSection('vaccinations')">Vaccinations</li>
                    <li class="list-group-item border-0" onclick="showSection('vitalSigns')">Signes Vitaux</li>
                    <li class="list-group-item border-0" onclick="showSection('appointmentHistory')">Historique de
                        Rendez-vous
                    </li>
                    @if(auth()->user()->role === 'patient')
                        <li class="list-group-item border-0" onclick="showSection('security')">Sécurité</li>
                    @endif

                </ul>
            </div>
            <div class="col-md-9">
                <div class="container-fluid">
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

                    <div id="consultationReports" class="section card">
                        <x-patient-record.full-consultations-reports
                            :consultationReports="$consultationReports"
                            :patient="$patient"></x-patient-record.full-consultations-reports>
                    </div>
                    <div id="vaccinations" class="section">
                        <h2>Vaccinations</h2>

                    </div>
                    <div id="vitalSigns" class="section">
                        <x-patient-record.vital-signs
                            :vital_signs="$medicalRecord->vital_signs"></x-patient-record.vital-signs>

                    </div>
                    <div id="appointmentHistory" class="section card">
                        @if(auth()->user()->role === 'patient')
                            <x-patient-record.appointments-table :appointments="$appointments"> </x-patient-record.appointments-table>
                        @else
                            <x-doctor-patient-appointments-table
                                :appointments="$appointments"></x-doctor-patient-appointments-table>
                        @endif
                    </div>
                    <div id="security" class="section">
                        <x-security></x-security>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
            document.querySelectorAll('.list-group-item').forEach(item => {
                item.classList.remove('active');
            });
            document.querySelector(`.list-group-item[onclick="showSection('${sectionId}')"]`).classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function () {
            showSection('generalInfo');

            function showMessage(message, isSuccess) {
                const messageContainer = document.getElementById('message-container');
                const messageText = messageContainer.querySelector('.alert-text');

                messageText.textContent = message;
                messageContainer.classList.remove('alert-primary', 'alert-success');
                messageContainer.classList.add(isSuccess ? 'alert-success' : 'alert-primary');
                messageContainer.style.display = 'block';
            }
        });
    </script>
@endsection
