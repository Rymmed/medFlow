@props(['user', 'appointment'])

<div class="card">
    <div class="position-relative mt-3">
        <x-profile-image :class="'avatar avatar-xl border-opacity-100 border-radius-section shadow-card'"
                         :image="$user->profile_image"></x-profile-image>
        @if(auth()->user()->role === 'patient')
            <x-edit-image-btn></x-edit-image-btn>
        @endif
    </div>
    <h6 class="font-weight-bolder card-title mt-3">{{ $user->firstName }} {{ $user->lastName }}</h6>
    <p class="text-sm text-dark">
        @if($user->gender === 0)
            {{ __('Homme') }}
        @else
            {{ __('Femme') }}
        @endif, {{ \Carbon\Carbon::parse($user->dob)->age }} {{ __('ans') }}
    </p>
    <p class="text-secondary text-sm">{{ $user->email }}</p>
    <div>
        @if(auth()->user()->role === 'patient' && Route::is('dashboard'))
            <a href="{{ route('myProfile') }}" type="button" class="btn bg-gradient-blue text-white btn-md">
                Modifier profil
            </a>
        @endif
        @if(auth()->user()->role === 'doctor' && isset($appointment) && $appointment->status === \App\Enums\AppointmentStatus::CONFIRMED)
            <p class="text-primary">
                Rendez-vous :<br> {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/y à H:i') }}
            </p>
            <a href="{{ route('consultationReport.create', ['appointment_id' => $appointment->id]) }}"
               class="btn bg-gradient-blue text-white btn-md">
                <i class="far fa-plus me-1"></i> Rapport
            </a>

            @if ($appointment->consultation_type === \App\Enums\ConsultationType::ONLINE)
                <form action="{{ route('consultations.start', ['appointmentId' => $appointment->id]) }}" method="POST">
                    @csrf
                    <button type="submit" formtarget="_blank" class="btn bg-gradient-blue text-white btn-md">
                        <i class="fa fa-video me-1"></i> Démarrer
                    </button>
                </form>
            @endif
        @endif
    </div>
</div>
