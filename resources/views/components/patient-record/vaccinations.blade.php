@props(['vaccinations'])

<div class="accordion-item mt-2">
    <div class="card">
        <h6 class="mb-0 accordion-header" id="headingVaccinations">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseVaccinations" aria-expanded="true"
               aria-controls="collapseVaccinations" onclick="toggleIcon('vaccinations')">
                <span>{{ __('Vaccinations') }}</span>
                <x-toggle-icon-component id="vaccinations"/>
            </a>
        </h6>
        <div id="collapseVaccinations" class="accordion-collapse collapse show"
             aria-labelledby="headingVaccinations">
            <div class="card-body">
                @foreach($vaccinations as $vaccination)
                    <p>{{ $vaccination->title }} - {{ $vaccination->date }}</p>
                @endforeach
            </div>
        </div>
    </div>
</div>
