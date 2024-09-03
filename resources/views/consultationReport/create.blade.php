@extends('layouts.user_type.auth')

@section('content')
    <div class="container ">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3>Créer le rapport de consultation</h3>
                <div id="message-container" class="mt-3 alert alert-dismissible fade show" role="alert"
                     style="display: none;">
                    <span class="alert-text text-white"></span>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="fa fa-close" aria-hidden="true"></i>
                    </button>
                </div>
                <form id="multi-step-form" method="POST" action="{{ route('consultationReport.store', $appointment->id) }}">
                    @csrf
                    <!-- Step 1: Consultation Report -->
                    <div id="step-1" class="form-step">
                        <div class="form-group">
                            <label for="visit_type">Type de Visite</label>
                            <input type="text" id="visit_type" name="visit_type" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="symptoms">Symptômes</label>
                            <textarea id="symptoms" name="symptoms" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="diagnostic_hypotheses">Hypothèses Diagnostiques</label>
                            <textarea id="diagnostic_hypotheses" name="diagnostic_hypotheses" class="form-control" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="final_diagnosis">Diagnostic Final</label>
                            <textarea id="final_diagnosis" name="final_diagnosis" class="form-control" required></textarea>
                        </div>
                        <button type="button" class="btn btn-primary next-step">Suivant</button>
                        <button type="submit" class="btn btn-success">Enregistrer le rapport seulement</button>
                    </div>

                    <!-- Step 2: Prescription (Optional) -->
                    <div id="step-2" class="form-step d-none">
                        <div class="form-group">
                            <label for="treatment">Traitement</label>
                            <input type="text" id="treatment" name="treatment" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control"></textarea>
                        </div>
                        <button type="button" class="btn btn-secondary previous-step">Retour</button>
                        <button type="button" class="btn btn-primary next-step">Suivant</button>
                        <button type="submit" class="btn btn-success">Enregistrer le rapport et l'ordonnance</button>
                    </div>

                    <!-- Step 3: Prescription Lines (Optional) -->
                    <div id="step-3" class="form-step d-none">
                        <div class="card">
                            <div class="card-header">
                                <h5>Lignes de l'ordonnance</h5>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Nom du médicament</th>
                                        <th>Dose</th>
                                        <th>Durée</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody id="prescription-lines-table">
                                    <!-- Prescription lines will be added here dynamically -->
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#lineModal">Ajouter Ligne</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary previous-step">Retour</button>
                        <button type="submit" class="btn btn-success">Enregistrer tout</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Adding Prescription Line -->
        <div class="modal fade" id="lineModal" tabindex="-1" role="dialog" aria-labelledby="lineModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="lineModalLabel">Ajouter Ligne de Prescription</h5>
                        <button type="button" class="btn-close"
                                data-bs-dismiss="modal" aria-label="Close">
                            <span class="text-dark" aria-hidden="true"><i
                                    class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-line-form">
                            <div class="form-group">
                                <label for="line-name">Nom du médicament</label>
                                <input type="text" id="line-name" name="line_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="line-dose">Dose</label>
                                <input type="text" id="line-dose" name="line_dose" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="line-duration">Durée</label>
                                <input type="text" id="line-duration" name="line_duration" class="form-control">
                            </div>
                            <button type="button" class="btn btn-success" id="add-line">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            let currentStep = 1;

            const showStep = (step) => {
                document.querySelectorAll('.form-step').forEach(stepElement => stepElement.classList.add('d-none'));
                document.getElementById(`step-${step}`).classList.remove('d-none');
            };

            document.querySelectorAll('.next-step').forEach(button => {
                button.addEventListener('click', () => {
                    currentStep++;
                    showStep(currentStep);
                });
            });

            document.querySelectorAll('.previous-step').forEach(button => {
                button.addEventListener('click', () => {
                    currentStep--;
                    showStep(currentStep);
                });
            });

            document.getElementById('add-line').addEventListener('click', () => {
                const name = document.getElementById('line-name').value;
                const dose = document.getElementById('line-dose').value;
                const duration = document.getElementById('line-duration').value;

                const table = document.getElementById('prescription-lines-table');
                const newRow = table.insertRow();
                newRow.insertCell(0).textContent = name;
                newRow.insertCell(1).textContent = dose;
                newRow.insertCell(2).textContent = duration;

                document.getElementById('add-line-form').reset();
                new bootstrap.Modal(document.getElementById('lineModal')).hide();
            });

            document.getElementById('multi-step-form').addEventListener('submit', function (e) {
                e.preventDefault();

                const formData = new FormData(this);
                const prescriptionLines = [...document.querySelectorAll('#prescription-lines-table tr')].map(row => ({
                    name: row.cells[0].textContent,
                    dose: row.cells[1].textContent,
                    duration: row.cells[2].textContent
                }));
                formData.append('prescription_lines', JSON.stringify(prescriptionLines));

                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data); // Vérifier la réponse
                        if (data.success) {
                            showMessage('Rapport de consultation et ordonnance créés avec succès', true);
                            const redirectUrl = `/consultationReport/show/${data.report_id}`;
                            console.log(redirectUrl); // Vérifier l'URL
                            window.location.href = redirectUrl;
                        } else {
                            showMessage(data.message || 'Erreur lors de la création du rapport de consultation et de l\'ordonnance', false);
                        }
                    })
                    .catch(error => showMessage('Erreur lors de la création du rapport de consultation et de l\'ordonnance', false));
            });
        });
    </script>
@endsection
