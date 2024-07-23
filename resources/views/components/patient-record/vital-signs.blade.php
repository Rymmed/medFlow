@props(['vital_signs'])

<div class="accordion-item mt-2">
    <div class="card">
        <h6 class="mb-0 accordion-header" id="headingVitalSigns">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseVitalSigns" aria-expanded="true"
               aria-controls="collapseVitalSigns"
               onclick="toggleIcon('vitalSigns')">
                <span>{{ __('Signes Vitaux') }}</span>
                <x-toggle-icon-component id="vitalSigns"/>
            </a>
        </h6>
        <div id="collapseVitalSigns" class="accordion-collapse collapse show"
             aria-labelledby="headingVitalSigns">
            <div class="card-body">
                @if($vital_signs)
                    @foreach($vital_signs as $vital)
                        <p>{{ $vital->type }}: {{ $vital->value }} {{ $vital->unit }}</p>
                    @endforeach
                @else
                    <p>Aucun signe trouvé.</p>
                @endif
            </div>
        </div>
    </div>
</div>

