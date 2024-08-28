@props(['doctors'])

<div class="accordion-item mt-2">
    <div class="card">
        <h5 class="mb-0 accordion-header" id="headingDoctors">
            <a class="accordion-button" type="button" data-bs-toggle="collapse"
               data-bs-target="#collapseDoctors" aria-expanded="true"
               aria-controls="collapseDoctors" onclick="toggleIcon('doctors')">
                <span>{{ __('Mes Médecins') }}</span>
                <x-toggle-icon-component id="doctors"/>
            </a>
        </h5>
        <div id="collapseDoctors" class="accordion-collapse collapse show mx-2"
             aria-labelledby="headingDoctors">
            @if($doctors->isEmpty())
                <p class="text-muted text-sm">{{ __('Aucun médecin trouvé.') }}</p>
            @else
                @foreach($doctors as $doctor)
                    <div class="row d-flex my-2">
                        <div class="col-2 m-2">
                            <x-profile-image :class="'avatar avatar-sm shadow-sm'" :image="$doctor->profile_image"></x-profile-image>
                        </div>
                        <div class="col-6 d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-xs">Dr. {{ $doctor->lastName }} {{ $doctor->firstName }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $doctor->doctor_info->speciality }}</p>
                        </div>
                        <div class="col-2 align-items-center">
                            <a href="{{ route('appointment.request', ['doctor_id' => $doctor->id]) }}"
                               class="text-primary"><i class="far fa-calendar-plus me-1"></i></a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
