@props(['vaccinations', 'medicalRecord'])

<div class="d-flex flex-row justify-content-between">
    <div>
        <h3 class="mt-4 ms-4">Vaccinations</h3>
    </div>
    <button class="btn bg-gradient-primary m-4" type="button" data-bs-toggle="modal"
            data-bs-target="#addVaccinationModal">
        <i class="far fa-plus me-1"></i> Ajouter
    </button>
</div>
<div class="row justify-content-evenly">
    @if($vaccinations->isEmpty())
        <p class="text-muted text-sm">{{ __('Aucune vaccination trouvée.') }}</p>
    @else
        @foreach($vaccinations as $vaccination)
            <div class="col-md-5 card mb-3 ">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div id="vaccination-{{ $vaccination->id }}">
                        <h6 class="mb-0"><span data-field="title-{{ $vaccination->id }}">{{ $vaccination->title }}</span></h6>
                        <small class="text-muted"><span data-field="date-{{ $vaccination->id }}">{{ \Carbon\Carbon::parse($vaccination->date)->format('d M, Y') }}</span></small>
                    </div>
                    <div>
                        <a href="#" class="text-primary" data-bs-toggle="modal"
                           data-bs-target="#updateVaccinationModal-{{ $vaccination->id }}">
                            <i class="fa fa-edit"></i>
                        </a>
                        <form id="destroy-{{ $vaccination->id }}" action="{{ route('vaccination.destroy', $vaccination->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <a type="button" class="mx-3 border-0" data-bs-toggle="modal" data-bs-target="#confirmationModal-{{ $vaccination->id }}"
                               data-bs-original-title="Supprimer">
                                <i class="fa fa-trash text-info"></i>
                            </a>
                        </form>

                        <!-- Confirmation Modal -->
                        <div class="modal fade" id="confirmationModal-{{ $vaccination->id }}" tabindex="-1" aria-labelledby="confirmationModalLabel-{{ $vaccination->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmationModalLabel-{{ $vaccination->id }}">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Êtes-vous sûr de vouloir supprimer ce vaccin?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Annuler</button>
                                        <button type="button" class="btn bg-gradient-danger" id="confirmDelete-{{ $vaccination->id }}" data-vaccination-id="{{ $vaccination->id }}">Supprimer</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal fade" id="updateVaccinationModal-{{ $vaccination->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="updateVaccinationModalTitle" aria-hidden="true">
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
                            <form id="update-vaccination-form-{{ $vaccination->id }}" method="POST"
                                  action="{{ route('vaccination.update', ['vaccination_id' => $vaccination->id]) }}">
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="title-{{ $vaccination->id }}" class="form-label">Titre</label>
                                        <input type="text" class="form-control" id="title-{{ $vaccination->id }}" name="title"
                                               value="{{ $vaccination->title }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date-{{ $vaccination->id }}" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="date-{{ $vaccination->id }}" name="date"
                                               value="{{ $vaccination->date }}">
                                    </div>
                                </div>

                                <button type="button" id="save-vaccination-button-{{ $vaccination->id }}" class="btn btn-primary">Sauvegarder</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
        <div class="modal fade" id="addVaccinationModal" tabindex="-1" role="dialog"
             aria-labelledby="addVaccinationModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Ajouter un vaccin') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="add-vaccination-form"
                              action="{{ route('vaccination.store', ['medicalRecord_id' => $medicalRecord->id]) }}"
                              method="POST">
                            @csrf
                            <div class="row">
                                <div class="form-group mb-3 col-md-6">
                                    <label for="new-vaccination-title">Titre</label>
                                    <input type="text" id="new-vaccination-title" name="title" class="form-control"
                                           placeholder="Titre">
                                </div>
                                <div class="form-group mb-3 col-md-6">
                                    <label for="new-date">Date</label>
                                    <input type="date" id="new-date" name="date"
                                              class="form-control"></input>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" id="add-vaccination-button"
                                        class="btn bg-gradient-primary">{{ __('Ajouter') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    document.getElementById('add-vaccination-button').addEventListener('click', function () {
        let form = document.getElementById('add-vaccination-form');
        $('#addVaccinationModal').modal('hide');
        showMessage('Ajout du vaccin avec succès', true);
        form.submit();

    });
    document.addEventListener('click', function(event) {
        if (event.target && event.target.id.startsWith('save-vaccination-button-')) {
            let vaccinationId = event.target.id.split('-').pop();
            let form = document.getElementById(`update-vaccination-form-${vaccinationId}`);
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
                        $(`#updateVaccinationModal-${vaccinationId}`).hide();
                        $('.modal-backdrop').remove();

                        const fieldMap = {
                            title: data.vaccination.title,
                            date: data.vaccination.date,
                        };

                        for (const field in fieldMap) {
                            document.querySelector(`#vaccination-${vaccinationId} span[data-field="${field}-${vaccinationId}"]`).textContent = fieldMap[field];
                        }
                    } else {
                        $(`#updateVaccinationModal-${vaccinationId}`).hide();
                        showMessage('Erreur lors de la mise à jour des informations médicales.', false);
                    }
                })
                .catch(error => console.error('Erreur:', error));
        }
    });
    document.querySelectorAll('[id^="confirmDelete-"]').forEach(button => {
        button.addEventListener('click', function () {
            let vaccinationId = this.getAttribute('data-vaccination-id');
            let form = document.getElementById('destroy-' + vaccinationId);
            $('#confirmationModal-' + vaccinationId).modal('hide');
            showMessage('Informations supprimées avec succès', true);
            form.submit();
        });
    });

</script>
