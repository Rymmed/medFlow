@props(['prescriptions'])

<div class="accordion-item">
    <div class="card">
        <h6 class="mb-0 accordion-header" id="headingPrescriptions">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapsePrescriptions" aria-expanded="true"
               aria-controls="collapsePrescriptions" onclick="toggleIcon('prescriptions')">
                <span>{{ __('Ordonnances') }}</span>
                <x-toggle-icon-component id="prescriptions"/>
            </a>
        </h6>
        <div id="collapsePrescriptions" class="accordion-collapse collapse show"
             aria-labelledby="headingPrescriptions">
            <div class="card-body">
                @if($prescriptions->isEmpty())
                    <div class="alert alert-info" role="alert">
                        {{ __('Aucune ordonnance disponible.') }}
                    </div>
                @else
                    <div class="container">
                        <div class="row">

                                @foreach($prescriptions as $prescription)
                                    <div class="col-md-6 mb-4">
                                        <div class="list-group-item flex-column align-items-start">
                                            <div class="d-flex w-100 justify-content-between">
                                                <small>{{ $prescription->created_at->format('d/m/Y') }}</small>
                                            </div>
                                            <p class="mb-1"><strong>{{ __('Traitement:') }}</strong> {{ $prescription->treatment }}</p>
                                            <p class="mb-1"><strong>{{ __('Description:') }}</strong> {{ $prescription->description }}</p>
                                            @if(!($prescription->prescriptionLines->isEmpty()))
                                                <div class="mt-2">
                                                    <h6>{{ __('Détails de la prescription:') }}</h6>
                                                    <ul class="list-unstyled">
                                                        @foreach($prescription->prescriptionLines as $line)
                                                            <li class="mb-2">
                                                                <span class="badge bg-primary">{{ $line->name }}</span>
                                                                <span class="text-muted">{{ $line->dose }} pendant {{ $line->duration }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                        </div>
                    </div>

                @endif
            </div>
        </div>
    </div>
</div>
