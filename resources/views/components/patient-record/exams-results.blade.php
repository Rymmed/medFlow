@props(['examResults', 'medicalRecord'])

<div class="d-flex justify-content-between align-items-center mb-0 accordion-header" id="headingExams">
    <div>
        <h5 class="mb-0">{{ __('Bilans Médicaux') }}</h5>
    </div>
    <button class="btn bg-gradient-primary btn-md mb-0 glow-button" type="button"
            data-bs-toggle="modal"
            data-bs-target="#addExamResultModal">
        <i class="far fa-plus me-1"></i> Bilan
    </button>

</div>

<div class="row p-3">
    @if($examResults->isEmpty())
        <p class="text-muted text-sm">{{ __('Aucun bilan médical disponible.') }}</p>
    @else
        @foreach($examResults as $examResult)
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <div class="dropdown text-end">
                                <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown" aria-expanded="false"
                                   style="cursor: pointer;"></i>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                           data-bs-target="#updateExamResultModal-{{ $examResult->id }}"><i class="fa fa-edit me-2" ></i>Éditer</a>
                                    </li>
                                    <li>
                                        <form
                                            action="{{ route('examResult.destroy', ['examResult_id' => $examResult->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash-alt me-2"></i>{{ __('Supprimer') }}
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                            <h5 class="card-title">{{ $examResult->type }}</h5>
                            <p class="card-text">
                                <strong>{{ __('Résultat:') }} </strong>{{ $examResult->result ?? __('Non disponible') }}
                                <br>
                                <strong>{{ __('Date:') }} </strong>{{ \Carbon\Carbon::parse($examResult->date)->format('d M, Y') }}
                            </p>
                            @if($examResult->doc)
                                <a href="{{ route('download.doc', $examResult->doc) }}"
                                   class="btn btn-outline-primary btn-sm mt-2" target="_blank">
                                    <i class="fas fa-download me-1"></i>{{ __('Télécharger le document') }}
                                </a>
                            @else
                                <span class="text-muted">{{ __('Aucun document') }}</span>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
            <!-- Update ExamResult Modal -->
            <div class="modal fade" id="updateExamResultModal-{{ $examResult->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="updateExamResultModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ __('Mettre à jour Résultat d\'Examen') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <span class="text-dark" aria-hidden="true"><i class="fa fa-close"></i></span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="update-exam-result-form-{{ $examResult->id }}" method="POST"
                                  action="{{ route('examResult.update', ['examResult_id' => $examResult->id]) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="exam-type-{{ $examResult->id }}" class="form-label">Type</label>
                                        <input type="text" class="form-control" id="exam-type-{{ $examResult->id }}"
                                               name="type"
                                               value="{{ $examResult->type }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="exam-date-{{ $examResult->id }}" class="form-label">Date</label>
                                        <input type="date" class="form-control" id="exam-date-{{ $examResult->id }}"
                                               name="date"
                                               value="{{ $examResult->date }}">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="result-{{ $examResult->id }}" class="form-label">Résultat</label>
                                    <textarea class="form-control" id="result-{{ $examResult->id }}"
                                              name="result">{{ $examResult->result }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="doc-{{ $examResult->id }}" class="form-label">Document</label>
                                    <input type="file" class="form-control" id="doc-{{ $examResult->id }}"
                                           name="doc">
                                </div>

                                <button type="submit" class="btn btn-primary">Sauvegarder</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="modal fade" id="addExamResultModal" tabindex="-1" role="dialog" aria-labelledby="addExamResultModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExamResultModalLabel">{{ __('Ajouter Résultat d\'Examen') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add-exam-result-form" method="POST"
                      action="{{ route('examResult.store', ['medicalRecord_id' => $medicalRecord->id]) }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="add-exam-type" class="form-label">Type d'Examen</label>
                        <input type="text" class="form-control" id="add-exam-type" name="type" required>
                    </div>
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="mb-3">
                        <label for="doc" class="form-label">Document (facultatif)</label>
                        <input type="file" class="form-control" id="doc" name="doc"
                               accept=".jpeg,.png,.jpg,.pdf,.doc,.docx">
                    </div>
                    <div class="mb-3">
                        <label for="result" class="form-label">Résultat</label>
                        <textarea class="form-control" id="result" name="result"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
        </div>
    </div>
</div>


