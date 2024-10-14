@props(['medicalRecord'])

<div class="d-flex flex-row justify-content-between">
    <div>
        <h3 class="mt-4 ms-4">Signes Vitaux</h3>
    </div>
</div>
<div class="row ms-2" id="vital-signs">
    <div class="mt-2">
        <strong class="me-3">Température:</strong>
        <span data-field="temperature">{{ $medicalRecord->temperature }} °C</span>
    </div>
    <div class="mt-2">
        <strong class="me-3">Fréquence Cardiaque:</strong>
        <span data-field="heart_rate">{{ $medicalRecord->heart_rate }} bpm</span>
    </div>
    <div class="mt-2">
        <strong class="me-3">Tension Artérielle:</strong>
        <span data-field="blood_pressure">{{ $medicalRecord->blood_pressure }} cmHg</span>
    </div>
    <div class="mt-2">
        <strong class="me-3">Fréquence Respiratoire:</strong>
        <span data-field="respiratory_rate">{{ $medicalRecord->respiratory_rate }} rpm</span>
    </div>
    <div class="mt-2">
        <strong class="me-3">Saturation d'oxygène:</strong>
        <span data-field="oxygen_saturation">{{ $medicalRecord->oxygen_saturation }} %</span>
    </div>
    <div class="mt-2">
        <button class="btn bg-gradient-primary m-4" type="button" data-bs-toggle="modal"
                data-bs-target="#updateVitalSignsModal">
            <i class="fa fa-edit me-1"></i> Modifier
        </button>
    </div>
    <div class="modal fade" id="updateVitalSignsModal" tabindex="-1" role="dialog"
         aria-labelledby="updateVitalSignsModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Mettre à jour') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close">
                                            <span class="text-dark" aria-hidden="true"><i
                                                    class="fa fa-close"></i></span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="update-vital-signs-form" method="POST"
                          action="{{ route('vitalSigns.update', ['medicalRecord_id' => $medicalRecord->id]) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="temperature" class="form-label">Température (°C)</label>
                                <input type="number" class="form-control" id="temperature" name="temperature"
                                       value="{{ $medicalRecord->temperature }}">
                            </div>
                            <div class="col-md-6">
                                <label for="heart_rate" class="form-label">Fréquence Cardiaque (bpm)</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate"
                                       value="{{ $medicalRecord->heart_rate }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="blood_pressure" class="form-label">Tension Artérielle (cmHg)</label>
                                <input type="text" class="form-control" id="blood_pressure" name="blood_pressure"
                                       value="{{ $medicalRecord->blood_pressure }}">
                            </div>
                            <div class="col-md-6">
                                <label for="respiratory_rate" class="form-label">Fréquence Respiratoire (rpm)</label>
                                <input type="number" class="form-control" id="respiratory_rate" name="respiratory_rate"
                                       value="{{ $medicalRecord->respiratory_rate }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="oxygen_saturation" class="form-label">Saturation d'oxygène (%)</label>
                                <input type="number" class="form-control" id="oxygen_saturation"
                                       name="oxygen_saturation" value="{{ $medicalRecord->oxygen_saturation }}">
                            </div>
                        </div>

                        <button type="button" id="save-vital-signs-button" class="btn btn-primary">Sauvegarder</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('save-vital-signs-button').addEventListener('click', function() {
        let form = document.getElementById('update-vital-signs-form');
        let formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Informations modifiées avec succès', true);
                    $('#updateVitalSignsModal').hide();
                    $('.modal-backdrop').remove();
                    // Mettre à jour le DOM avec les nouvelles valeurs
                    const fieldMap = {
                        temperature: `${data.medicalRecord.temperature} °C`,
                        heart_rate: `${data.medicalRecord.heart_rate} bpm`,
                        blood_pressure: `${data.medicalRecord.blood_pressure} cmHg`,
                        respiratory_rate: `${data.medicalRecord.respiratory_rate} rpm`,
                        oxygen_saturation: `${data.medicalRecord.oxygen_saturation} %`,
                    };

                    for (const field in fieldMap) {
                        document.querySelector(`#vital-signs span[data-field="${field}"]`).textContent = fieldMap[field];

                    }

                } else {
                    $('#updateVitalSignsModal').hide();
                    showMessage('Erreur lors de la mise à jour des informations médicales.', false);
                }
            })
            .catch(error => console.error('Erreur:', error));
    });
</script>
