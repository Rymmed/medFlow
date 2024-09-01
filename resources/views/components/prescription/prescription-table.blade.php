<div class="card">
    <div class="card-header pb-0">
        <div class="d-flex flex-row justify-content-between">
            <div>
                <h5 class="mb-0">Lignes de l'ordonnance</h5>
            </div>
            <button class="btn bg-gradient-blue text-white btn-md mb-0" type="button" data-bs-toggle="modal" data-bs-target="#LineCreationModal">
                <i class="far fa-plus me-1"></i> Ligne
            </button>
        </div>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0" id="prescription-lines-table">
                <thead>
                <tr>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Médicament</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dose</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durée</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($lines))
                    @foreach ($lines as $line)
                        <tr>
                            <td><p
                                    class="text-center text-xs font-weight-bold mb-0">{{ $line->name }}</p></td>
                            <td><p
                                    class="text-center text-xs font-weight-bold mb-0">{{ $line->dose }}</p></td>
                            <td><p
                                    class="text-center text-xs font-weight-bold mb-0">{{ $line->duration }}</p></td>
                            <td class="text-center">
                                <a href="#" class="text-blue me-2" data-bs-toggle="modal" data-bs-target="#editLineModal-{{ $line->id }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#deleteLineModal-{{ $line->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <div class="modal fade" id="editLineModal-{{ $line->id }}" tabindex="-1" role="dialog" aria-labelledby="editLineModalLabel-{{ $line->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editLineModalLabel-{{ $line->id }}">Modifier la ligne de prescription</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('prescription-lines.update', $line->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label for="line-name-{{ $line->id }}">Nom du médicament</label>
                                                <input type="text" class="form-control" id="line-name-{{ $line->id }}" name="name" value="{{ $line->name }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="line-dose-{{ $line->id }}">Dose</label>
                                                <input type="text" class="form-control" id="line-dose-{{ $line->id }}" name="dose" value="{{ $line->dose }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="line-duration-{{ $line->id }}">Durée</label>
                                                <input type="text" class="form-control" id="line-duration-{{ $line->id }}" name="duration" value="{{ $line->duration }}">
                                            </div>
                                            <button type="submit" class="btn btn-success">Mettre à jour</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="deleteLineModal-{{ $line->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteLineModalLabel-{{ $line->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteLineModalLabel-{{ $line->id }}">Confirmer la suppression</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                            <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Êtes-vous sûr de vouloir supprimer cette ligne de prescription ?</p>
                                        <form action="{{ route('prescription-lines.destroy', $line->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal pour ajouter une ligne de prescription -->
<div class="modal fade" id="LineCreationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-line-form">
                    @csrf
                    <div class="form-group">
                        <label for="line-name">Nom du médicament</label>
                        <input type="text" class="form-control" id="line-name" name="name">
                    </div>
                    <div class="form-group">
                        <label for="line-dose">Dose</label>
                        <input type="text" class="form-control" id="line-dose" name="dose">
                    </div>
                    <div class="form-group">
                        <label for="line-duration">Durée</label>
                        <input type="text" class="form-control" id="line-duration" name="duration">
                    </div>
                    <button type="submit" class="btn btn-success">Ajouter Ligne</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('add-line-form').addEventListener('submit', function(e) {
        e.preventDefault();

        if (!prescriptionId) {
            showMessage('Vous devez créer l\'ordonnance avant', false);
            return;
        }

        const formData = new FormData(this);
        formData.append('prescription_id', prescriptionId);

        fetch('{{ route('prescription-lines.store') }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const table = document.getElementById('prescription-lines-table').querySelector('tbody');
                    const newRow = table.insertRow();

                    // Insérer les colonnes avec le format souhaité
                    newRow.insertCell(0).innerHTML = `<p class="text-center text-xs font-weight-bold mb-0">${data.line.name}</p>`;
                    newRow.insertCell(1).innerHTML = `<p class="text-center text-xs font-weight-bold mb-0">${data.line.dose}</p>`;
                    newRow.insertCell(2).innerHTML = `<p class="text-center text-xs font-weight-bold mb-0">${data.line.duration}</p>`;


                    // Insert action buttons cell
                    const actionCell = newRow.insertCell(3);
                    actionCell.className = 'text-center';

                    // Create edit button
                    const editButton = document.createElement('a');
                    editButton.href = '#';
                    editButton.className = 'text-blue me-2';
                    editButton.setAttribute('data-bs-toggle', 'modal');
                    editButton.setAttribute('data-bs-target', `#editLineModal-${data.line.id}`);
                    editButton.innerHTML = '<i class="fas fa-edit"></i>';

                    // Create delete button
                    const deleteButton = document.createElement('a');
                    deleteButton.href = '#';
                    deleteButton.className = 'text-primary';
                    deleteButton.setAttribute('data-bs-toggle', 'modal');
                    deleteButton.setAttribute('data-bs-target', `#deleteLineModal-${data.line.id}`);
                    deleteButton.innerHTML = '<i class="fas fa-trash-alt"></i>';

                    // Append buttons to action cell
                    actionCell.appendChild(editButton);
                    actionCell.appendChild(deleteButton);

                    // Reset the form and hide the modal
                    document.getElementById('add-line-form').reset();
                    $('#LineCreationModal').modal('hide');

                } else {
                    showMessage('Échec dans l\'ajout d\'une ligne', false);
                }
            });
    });
</script>
