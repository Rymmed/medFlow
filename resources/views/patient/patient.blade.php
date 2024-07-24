@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <x-patient-record.profile-card></x-patient-record.profile-card>
                    <button class="btn btn-primary">Contact</button>
                    <ul class="menu list-group mt-3">
                        <li class="list-group-item" onclick="showSection('generalInfo')">Informations Générales</li>
                        <li class="list-group-item" onclick="showSection('medicalHistory')">Antécédents Médicales</li>
                        <li class="list-group-item" onclick="showSection('consultationReports')">Rapports de Consultations</li>
                        <li class="list-group-item" onclick="showSection('vaccinations')">Vaccinations</li>
                        <li class="list-group-item" onclick="showSection('vitalSigns')">Signes Vitaux</li>
                        <li class="list-group-item" onclick="showSection('appointmentHistory')">Historique de Rendez-vous</li>
                        <li class="list-group-item" onclick="showSection('passwordManagement')">Sécurité</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <!-- Content Area -->
                <div id="generalInfo" class="section active">
                    <h2>Informations Générales</h2>
                    <h3>Section 1</h3>
                    <p>Email: {{ $patient->email }}</p>
                    <p>Téléphone: {{ $patient->phone }}</p>
                    <!-- More details here -->
                    <h3>Section 2</h3>
                    <p>Height: {{ $patient->height }}</p>
                    <p>Weight: {{ $patient->weight }}</p>
                    <!-- More details here -->
                </div>
                <div id="medicalHistory" class="section">
                    <h2>Antécédents Médicales</h2>
                    <!-- Medical history details here -->
                </div>
                <div id="consultationReports" class="section">
                    <h2>Rapports de Consultations</h2>
                    <!-- Consultation reports details here -->
                </div>
                <div id="vaccinations" class="section">
                    <h2>Vaccinations</h2>
                    <!-- Vaccinations details here -->
                </div>
                <div id="vitalSigns" class="section">
                    <h2>Signes Vitaux</h2>
                    <!-- Vital signs details here -->
                </div>
                <div id="appointmentHistory" class="section">
                    <h2>Historique de Rendez-vous</h2>
                    <!-- Appointment history details here -->
                </div>
                <div id="passwordManagement" class="section">
                    <x-security></x-security>
                </div>
            </div>
        </div>
    </div>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(section => {
                section.classList.remove('active');
            });
            document.getElementById(sectionId).classList.add('active');
        }
    </script>
@endsection
