@props(['user', 'appointment'])

<div class="card">
    <div class="position-relative mt-3">
        <x-profile-image :class="'avatar avatar-xl border-opacity-100 border-radius-section shadow-card me-2'"
                         :image="$user->profile_image"></x-profile-image>
        {{--                    <x-edit-image-btn></x-edit-image-btn>--}}
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
        @if(auth()->user()->role === 'patient')
            <a href="{{ route('myProfile') }}" type="button" class="btn bg-gradient-blue text-white btn-md">Modifier
                profil</a>
        @elseif(auth()->user()->role === 'doctor')
            <p class="text-primary">Rendez-vous: {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/y à H:i') }}</p>
            <a href="{{ route('consultationReport.create', ['appointment_id' => $appointment->id]) }}" type="button" class="btn bg-gradient-blue text-white btn-md"><i class="far fa-plus me-1"></i>Rapport de consultation</a>
        @endif
    </div>
</div>
