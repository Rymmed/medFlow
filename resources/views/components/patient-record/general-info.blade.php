@props(['patient', 'medicalRecord'])

<div class="d-flex flex-row justify-content-between">
    <div>
        <h3 class="mt-4 ms-4">Informations Générales</h3>
    </div>
</div>
<div class="row ms-2">
    <ul class="nav nav-tabs" id="infosTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="personal-infos-tab" data-bs-toggle="tab"
                    data-bs-target="#personal-infos"
                    type="button" role="tab" aria-controls="personal-infos"
                    aria-selected="false">Personnelles
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="medical-infos-tab" data-bs-toggle="tab"
                    data-bs-target="#medical-infos"
                    type="button" role="tab" aria-controls="medical-infos"
                    aria-selected="false">Médicales
            </button>
        </li>
    </ul>
    <div class="tab-content" id="infosTabContent">
        <div class="tab-pane fade show active" id="personal-infos" role="tabpanel"
             aria-labelledby="personal-infos-tab">
            <div class="mt-2">
                <strong class="me-3">Adresse:</strong>
                <span>{{ $patient->address }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Ville:</strong>
                <span>{{ $patient->city }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Pays:</strong>
                <span>{{ $patient->country }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Email:</strong>
                <span>{{ $patient->email }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Téléphone:</strong>
                <span>{{ $patient->phone_number }}</span>
            </div>
            <div class="mt-2 mb-4">
                <strong class="me-3">Date de Naissance:</strong>
                <span>{{ \Carbon\Carbon::parse($patient->dob)->format('d/m/Y') }}</span>
            </div>
            @if(auth()->user()->id === $patient->id)
                <button class="btn bg-gradient-primary m-4" type="button" data-bs-toggle="modal"
                        data-bs-target="#updatePersonalInfosModal">
                    <i class="fa fa-edit me-1"></i> Modifier
                </button>
                <div class="modal fade" id="updatePersonalInfosModal" tabindex="-1" role="dialog"
                     aria-labelledby="updatePersonalInfosModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">{{ __('Ajouter un antécédent') }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close">
                                            <span class="text-dark" aria-hidden="true"><i
                                                    class="fa fa-close"></i></span>
                                </button>
                            </div>
                            <div class="modal-body">

                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="tab-pane fade" id="medical-infos" role="tabpanel"
             aria-labelledby="medical-infos-tab">
            <div class="mt-2">
                <strong class="me-3">Poids:</strong>
                <span data-field="weight">{{ $medicalRecord->weight }} kg</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Taille:</strong>
                <span data-field="height">{{ $medicalRecord->height }} cm</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Groupe Sanguin:</strong>
                <span data-field="blood_group">{{ $medicalRecord->blood_group ?  : 'nom rempli' }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Milieu:</strong>
                <span data-field="area">{{ $medicalRecord->area ?  : 'nom rempli' }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Fumeur:</strong>
                <span data-field="smoking">{{ $medicalRecord->smoking ? 'Oui' : 'Non' }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Alcool:</strong>
                <span data-field="alcohol">{{ $medicalRecord->alcohol ? 'Oui' : 'Non' }}</span>
            </div>
            <div class="mt-2">
                <strong class="me-3">Activité physique:</strong>
                <span data-field="sedentary_lifestyle">{{ $medicalRecord->sedentary_lifestyle ? 'Non' : 'Oui' }}</span>
            </div>
            <button class="btn bg-gradient-primary m-4" type="button" data-bs-toggle="modal"
                    data-bs-target="#updateMedicalInfosModal">
                <i class="fa fa-edit me-1"></i> Modifier
            </button>
            <div class="modal fade" id="updateMedicalInfosModal" tabindex="-1" role="dialog"
                 aria-labelledby="updateMedicalInfosModalTitle" aria-hidden="true">
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
                            <form id="update-medical-infos-form" method="POST" action="{{ route('medicalRecord.update', ['medicalRecord_id' => $medicalRecord->id]) }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Poids (kg)</label>
                                        <input type="number" class="form-control" id="weight" name="weight" value="{{ $medicalRecord->weight }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="height" class="form-label">Taille (cm)</label>
                                        <input type="number" class="form-control" id="height" name="height" value="{{ $medicalRecord->height }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="blood_group" class="form-label">Groupe Sanguin</label>
                                        <select class="form-control" id="blood_group" name="blood_group">
                                            @foreach(\App\Enums\BloodGroup::getValues() as $blood_group)
                                                <option value="{{ $blood_group }}">{{ $blood_group }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="area" class="form-label">Milieu</label>
                                        <select class="form-control" id="area" name="area">
                                            @foreach(\App\Enums\PatientArea::getValues() as $area)
                                                <option value="{{ $area }}" {{ $area == $medicalRecord->area ? 'selected' : '' }}>{{ $area }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Fumeur</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="smoking" id="smoking-yes" value="1" {{ $medicalRecord->smoking ? 'checked' : '' }}>
                                                <label class="form-check-label" for="smoking-yes">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="smoking" id="smoking-no" value="0" {{ !$medicalRecord->smoking ? 'checked' : '' }}>
                                                <label class="form-check-label" for="smoking-no">Non</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Alcool</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol-yes" value="1" {{ $medicalRecord->alcohol ? 'checked' : '' }}>
                                                <label class="form-check-label" for="alcohol-yes">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="alcohol" id="alcohol-no" value="0" {{ !$medicalRecord->alcohol ? 'checked' : '' }}>
                                                <label class="form-check-label" for="alcohol-no">Non</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Activité physique</label>
                                        <div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sedentary_lifestyle" id="sedentary_lifestyle-yes" value="0" {{ !$medicalRecord->sedentary_lifestyle ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sedentary_lifestyle-yes">Oui</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="sedentary_lifestyle" id="sedentary_lifestyle-no" value="1" {{ $medicalRecord->sedentary_lifestyle ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sedentary_lifestyle-no">Non</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" id="save-medical-infos-button" class="btn btn-primary">Sauvegarder</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('save-medical-infos-button').addEventListener('click', function() {
        let form = document.getElementById('update-medical-infos-form');
        let formData = new FormData(form);

        fetch(form.action, {  // Remplacez par l'URL appropriée pour la mise à jour
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
                    $('#updateMedicalInfosModal').hide();
                    // Mettre à jour le DOM avec les nouvelles valeurs
                    const fieldMap = {
                        weight: `${data.medicalRecord.weight}kg`,
                        height: `${data.medicalRecord.height}cm`,
                        blood_group: data.medicalRecord.blood_group,
                        area: data.medicalRecord.area,
                        smoking: data.medicalRecord.smoking ? 'Oui' : 'Non',
                        alcohol: data.medicalRecord.alcohol ? 'Oui' : 'Non',
                        sedentary_lifestyle: data.medicalRecord.sedentary_lifestyle ? 'Non' : 'Oui'
                    };

                    for (const field in fieldMap) {
                        document.querySelector(`#medical-infos span[data-field="${field}"]`).textContent = fieldMap[field];
                    }
                } else {
                    $('#updateMedicalInfosModal').hide();
                    showMessage('Erreur lors de la mise à jour des informations médicales.', false);
                }
            })
            .catch(error => console.error('Erreur:', error));
    });

</script>
