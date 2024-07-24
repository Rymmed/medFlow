@props(['medicalHistories'])

<div class="accordion-item mt-2">
    <div class="card">
        <h6 class="mb-0 accordion-header" id="headingMedicalHistory">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseMedicalHistory" aria-expanded="true"
               aria-controls="collapseMedicalHistory" onclick="toggleIcon('medicalHistory')">
                <span>{{ __('Antécédents Médicaux') }}</span>
                <x-toggle-icon-component id="medicalHistory"/>
            </a>
        </h6>
        <div id="collapseMedicalHistory" class="accordion-collapse collapse show"
             aria-labelledby="headingMedicalHistory">
            <div class="card-body">
                @if(!($medicalHistories->isEmpty()))
                    @foreach($medicalHistories as $history)
                        <p>{{ $history->type }} - {{ $history->subtype }}: {{ $history->title }}</p>
                    @endforeach
                @else
                    <p>Pas d'antécédents remplis.</p>
                @endif
            </div>
        </div>
    </div>
</div>
