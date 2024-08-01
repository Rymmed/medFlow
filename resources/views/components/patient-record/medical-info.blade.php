@props(['medicalRecord', 'insuranceDetails'])

<div class="accordion-item mt-2">
    <div class="card px-2">
        <h5 class="mb-0 accordion-header" id="headingMedicalInfo">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseMedicalInfo" aria-expanded="true"
               aria-controls="collapseMedicalInfo" onclick="toggleIcon('MedicalInfo')">
                <span>{{ __('Informations générales') }}</span>
                <x-toggle-icon-component id="MedicalInfo"/>
            </a>
        </h5>
        <div class="accordion-collapse collapse show mx-2" id="collapseMedicalInfo"
             aria-labelledby="headingMedicalInfo">
            <p class="text-sm text-dark text-bold info-text">{{ __('Taille') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->height ? $medicalRecord->height : 'non rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Poids') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->weight ? $medicalRecord->weight : 'non rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Adresse') }}: <span
                    class="text-secondary ms-4">{{ auth()->user()->address ? auth()->user()->address : 'non rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Ville') }}: <span
                    class="text-secondary ms-4">{{ auth()->user()->city ? auth()->user()->city : 'nom rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Groupe Sanguin') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->blood_group ? $medicalRecord->blood_group : 'non rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Zone') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->area ? $medicalRecord->area : 'non rempli' }}</span>
            </p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Tabagisme') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->smoking ? 'Oui' : 'Non' }}</span></p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Alcool') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->alcohol ? 'Oui' : 'Non' }}</span></p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Activité Physique') }}: <span
                    class="text-secondary ms-4">{{ $medicalRecord->sedentary_lifestyle ? 'Non' : 'Oui' }}</span></p>
            <p class="text-sm text-dark text-bold info-text">{{ __('Assurance') }}: <span
                    class="text-secondary ms-4">{{ $insuranceDetails ? $insuranceDetails->type . '-' . $insuranceDetails->number : 'non rempli' }}</span>
            </p>
        </div>
    </div>
</div>
