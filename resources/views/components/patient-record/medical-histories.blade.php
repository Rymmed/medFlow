@props([
    'medicalRecord',
    'familialMedical',
    'familialSurgical',
    'personalMedical',
    'personalSurgical'
    ])

<div class="d-flex flex-row justify-content-between">
    <div>
        <h3 class="mt-4 ms-4">Antécédents Médicaux</h3>
    </div>
    <button class="btn bg-gradient-primary m-4" type="button" data-bs-toggle="modal"
            data-bs-target="#addHistoryModal">
        <i class="far fa-plus me-1"></i> Ajouter
    </button>
</div>

<div class="row mb-4">
    <!-- Antécédents Familiaux -->
    <div class="col-lg-6 border-end-md">
        <div class="card-header d-flex align-items-center">
            <i class="fas fa-users me-2"></i>
            <h4 class="mb-0">{{ __('Antécédents Familiaux') }}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="familialTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="familial-medical-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#familial-medical"
                            type="button" role="tab" aria-controls="familial-medical"
                            aria-selected="false">Médical
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="surgical-tab" data-bs-toggle="tab"
                            data-bs-target="#surgical"
                            type="button" role="tab" aria-controls="surgical"
                            aria-selected="false">Chirurgical
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="familialTabContent">
                <div class="tab-pane fade show active history-section" id="familial-medical"
                     role="tabpanel"
                     aria-labelledby="familial-medical-tab">
                    <x-patient-record.history-table
                        :histories="$familialMedical"></x-patient-record.history-table>
                </div>
                <div class="tab-pane fade history-section" id="surgical" role="tabpanel"
                     aria-labelledby="surgical-tab">
                    <x-patient-record.history-table
                        :histories="$familialSurgical"></x-patient-record.history-table>
                </div>
            </div>
        </div>
    </div>
    <!-- Antécédents Personnels -->
    <div class="col-md-6">
        <div class="card-header d-flex align-items-center">
            <i class="fas fa-user me-2"></i>
            <h4 class="mb-0">{{ __('Antécédents Personnels') }}</h4>
        </div>
        <div class="card-body">
            <ul class="nav nav-tabs" id="personalTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="personal-medical-tab"
                            data-bs-toggle="tab"
                            data-bs-target="#personal-medical"
                            type="button" role="tab" aria-controls="personal-medical"
                            aria-selected="false">Médical
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="personal-surgical-tab" data-bs-toggle="tab"
                            data-bs-target="#personal-surgical"
                            type="button" role="tab" aria-controls="personal-surgical"
                            aria-selected="false">Chirurgical
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="personalTabContent">
                <div class="tab-pane fade show active history-section" id="personal-medical"
                     role="tabpanel"
                     aria-labelledby="medical-tab">
                    <x-patient-record.history-table
                        :histories="$personalMedical"></x-patient-record.history-table>
                </div>
                <div class="tab-pane fade history-section" id="personal-surgical"
                     role="tabpanel"
                     aria-labelledby="surgical-tab">
                    <x-patient-record.history-table
                        :histories="$personalSurgical"></x-patient-record.history-table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal for adding new history -->
<div class="modal fade" id="addHistoryModal" tabindex="-1" role="dialog"
     aria-labelledby="addHistoryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Ajouter un antécédent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-history-form"
                      action="{{ route('medicalHistory.store', ['medicalRecord_id' => $medicalRecord->id]) }}"
                      method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control" aria-label="type">
                                @foreach(\App\Enums\MedicalHistType::getValues() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="subtype">Sous-type</label>
                            <select id="subtype" name="subtype" class="form-control"
                                    aria-label="subtype">
                                @foreach(\App\Enums\MedicalHistSubtype::getValues() as $subtype)
                                    <option value="{{ $subtype }}">{{ $subtype }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="title">Titre</label>
                            <input type="text" id="title" name="title" class="form-control"
                                   placeholder="Titre">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="description">Description</label>
                            <textarea id="description" name="description"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="add-history-button"
                                class="btn bg-gradient-primary">{{ __('Ajouter') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing history -->
<div class="modal fade" id="editHistoryModal" tabindex="-1" role="dialog"
     aria-labelledby="editHistoryModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Modifier un antécédent') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="edit-history-form"  method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="edit-type">Type</label>
                            <select id="edit-type" name="type" class="form-control">
                                @foreach(\App\Enums\MedicalHistType::getValues() as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="edit-subtype">Sous-type</label>
                            <select id="edit-subtype" name="subtype" class="form-control">
                                @foreach(\App\Enums\MedicalHistSubtype::getValues() as $subtype)
                                    <option value="{{ $subtype }}">{{ $subtype }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-6">
                            <label for="edit-title">Titre</label>
                            <input type="text" id="edit-title" name="title" class="form-control">
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            <label for="edit-description">Description</label>
                            <textarea id="edit-description" name="description"
                                      class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="update-history-button"
                                class="btn bg-gradient-primary">{{ __('Mettre à jour') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Handle add history form submission
    document.getElementById('add-history-button').addEventListener('click', function () {
        let form = document.getElementById('add-history-form');
        try {
            form.submit();
            showMessage('Ajout d\'antécédent avec succès', true);
            $('#addHistoryModal').modal('hide');
        } catch (error) {
            console.error('Erreur:', error);
            showMessage('Erreur lors de l\'ajout d\'antécédent', false);
        }
    });

    document.querySelectorAll('.edit-history-button').forEach(a => {
        a.addEventListener('click', function () {
            let historyId = a.getAttribute('data-id');
            let title = a.getAttribute('data-title');
            let description = a.getAttribute('data-description');
            let type = a.getAttribute('data-type');
            let subtype = a.getAttribute('data-subtype');

            document.querySelector(`#edit-type option[value="${type}"]`).selected = true;
            document.querySelector(`#edit-subtype option[value="${subtype}"]`).selected = true;

            document.getElementById('edit-title').value = title;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-type').value = type;
            document.getElementById('edit-subtype').value = subtype;

            document.getElementById('update-history-button').setAttribute('data-id', historyId);
        });
    });

    // Handle update history form submission
    document.getElementById('update-history-button').addEventListener('click', function () {
        let historyId = this.getAttribute('data-id');
        let form = document.getElementById('edit-history-form');
        form.action = `/medicalHistory/${historyId}`;
        try {
            form.submit();
            showMessage('Mise à jour réussie', true);
            $('#editHistoryModal').modal('hide');
        } catch (error) {
            console.error('Erreur:', error);
            showMessage('Erreur lors de la mise à jour', false);
        }
    });
</script>
