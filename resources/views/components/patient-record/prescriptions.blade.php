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
                    @foreach($prescriptions as $prescription)
                        <p><strong>Prescription ID:</strong> {{ $prescription->id }}</p>
                        @foreach($prescription->prescriptionLines as $line)
                            <p>{{ $line->name }} - {{ $line->dose }} - {{ $line->type }}
                                - {{ $line->duration }}</p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
