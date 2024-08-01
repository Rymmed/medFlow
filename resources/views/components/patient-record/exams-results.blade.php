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
            <div class="card-body">
                @foreach($examResults as $result)
                    <p>{{ $result->date }}: {{ $result->type }} - {{ $result->result }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
