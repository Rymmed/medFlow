@props(['examResults'])
<div class="accordion-item mt-2">
    <div class="card">
        <h6 class="mb-0 accordion-header" id="headingExams">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseExams" aria-expanded="true"
               aria-controls="collapseExams"
               onclick="toggleIcon('exams')">
                <span>{{ __('Résultats d\'Examen') }}</span>
                <x-toggle-icon-component id="exams"/>
            </a>
        </h6>
        <div id="collapseExams" class="accordion-collapse collapse show"
             aria-labelledby="headingExams">
{{--            <div class="card-body">--}}
{{--                @foreach($examResults as $result)--}}
{{--                    <p>{{ $result->date }}: {{ $result->type }} - {{ $result->result }}</p>--}}
{{--                @endforeach--}}
{{--            </div>--}}
            <div class="row">
                @foreach($examResults as $examResult)
                    <div class="col-md-6 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $examResult->type }}</h5>
                                <p class="card-text">
                                    <strong>Résultat: </strong>{{ $examResult->result }}<br>
                                    <strong>Date: </strong>{{ \Carbon\Carbon::parse($examResult->date)->format('d M, Y') }}
                                </p>
                                @if($examResult->doc)
                                    <a href="{{ route('download.doc', $examResult->doc) }}" class="btn btn-primary">Télécharger le document</a>
                                @else
                                    <span class="text-muted">Aucun document</span>
                                @endif
                                <div class="dropdown mt-2">
                                    <i class="fas fa-ellipsis-v" data-bs-toggle="dropdown" aria-expanded="false"
                                       style="cursor: pointer;"></i>
                                    <ul class="dropdown-menu">
                                        <li>
{{--                                            <a class="dropdown-item"--}}
{{--                                               href="{{ route('examResult.edit', ['examResult' => $examResult->id]) }}">Éditer</a>--}}
                                        </li>
                                        <li>
{{--                                            <a class="dropdown-item"--}}
{{--                                               href="{{ route('examResult.delete', ['examResult' => $examResult->id]) }}">Supprimer</a>--}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
