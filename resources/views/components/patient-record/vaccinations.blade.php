@props(['vaccinations'])

<div class="accordion-item mt-2">
    <div class="card">
        <h5 class="mb-0 accordion-header" id="headingVaccinations">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseVaccinations" aria-expanded="true"
               aria-controls="collapseVaccinations" onclick="toggleIcon('vaccinations')">
                <span>{{ __('Vaccinations') }}</span>
                <x-toggle-icon-component id="vaccinations"/>
            </a>
        </h5>
        <div id="collapseVaccinations" class="accordion-collapse collapse show mx-2"
             aria-labelledby="headingVaccinations">
            @if($vaccinations->isEmpty())
                <p class="text-muted text-sm">{{ __('Aucune vaccination trouvée.') }}</p>
            @else
                @foreach($vaccinations as $vaccination)
                    <p class="text-start text-sm text-dark text-bold info-text ms-3">
                        {{ $vaccination->title }}:
                        <span
                            class="text-secondary me-2">{{ \Carbon\Carbon::parse($vaccination->date)->format('d M, Y') }}</span>
                    </p>
                @endforeach
            @endif

        </div>
    </div>
</div>



