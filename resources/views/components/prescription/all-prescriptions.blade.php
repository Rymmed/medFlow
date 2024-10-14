<div class="container">
    <div class="row">
        <div class="col-md-12 card">
            <div class="card-header pb-0">
                <div class="d-flex flex-row justify-content-between">
                    <div>
                        <h5 class="mb-0">Ordonnances</h5>
                    </div>
{{--                    <a href="#"--}}
{{--                       class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button">--}}
{{--                        <i class="fa-solid fa-receipt me-1"></i> Ordonnance--}}
{{--                    </a>--}}
                </div>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                        <thead>
                        <tr>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Traitement
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Description
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Date
                                de Création
                            </th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($prescriptions as $prescription)
                            <tr>
                                <td class="text-center"><p
                                        class="text-xs font-weight-bold mb-0">{{ $prescription->treatment }}</p></td>
                                <td class="text-center"><p
                                        class="text-xs font-weight-bold mb-0">{{ $prescription->description }}</p></td>
                                <td class="text-center"><p
                                        class="text-xs font-weight-bold mb-0">{{ $prescription->created_at }}</p></td>
                                <td class="text-center">
                                    @if(isset($prescription->consultationReport) && auth()->user()->id === $prescription->consultationReport->doctor_id)
                                        <a href="{{ route('prescription.edit', $prescription->id) }}">
                                            <i class="fa-solid fa-edit text-blue me-2"></i></a>
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#deletePrescriptionModal-{{ $prescription->id }}">
                                            <i class="fa-solid fa-trash-alt text-primary"></i>
                                        </a>
                                        <div class="modal fade" id="deletePrescriptionModal-{{ $prescription->id }}"
                                             tabindex="-1" role="dialog"
                                             aria-labelledby="deleteLineModalLabel-{{ $prescription->id }}"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="deletePrescriptionModalLabel-{{ $prescription->id }}">
                                                            Confirmer
                                                            la suppression</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close">
                                                    <span class="text-dark" aria-hidden="true"><i
                                                            class="fa fa-close"></i></span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Êtes-vous sûr de vouloir supprimer ce rapport?</p>
                                                        <form
                                                            action="{{ route('prescription.destroy', ['prescription_id' => $prescription->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Supprimer
                                                            </button>
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Annuler
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('prescription.show', $prescription->id) }}"
                                        ><i
                                                class="fa-solid fa-eye"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
