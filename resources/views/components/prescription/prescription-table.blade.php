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
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom du médicament</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dose</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durée</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($lines))
                    @foreach ($lines as $line)
                        <tr>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $line->name }}</p></td>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $line->dose }}</p></td>
                            <td class="text-center"><p
                                    class="text-xs font-weight-bold mb-0">{{ $line->duration }}</p></td>
                        </tr>
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
