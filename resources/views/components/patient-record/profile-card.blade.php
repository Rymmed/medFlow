<div class="card">
<div class="position-relative mt-3">
    <x-profile-image :class="'avatar avatar-xl border-opacity-100 border-radius-section shadow-card me-2'" :image="auth()->user()->profile_image"></x-profile-image>
    {{--                    <x-edit-image-btn></x-edit-image-btn>--}}
</div>
<h6 class="font-weight-bolder card-title mt-3">{{ auth()->user()->firstName }} {{ auth()->user()->lastName }}</h6>
<p class="text-sm text-dark">
    @if(auth()->user()->gender === 0)
        {{ __('Homme') }}
    @else
        {{ __('Femme') }}
    @endif, {{ \Carbon\Carbon::parse(auth()->user()->dob)->age }} {{ __('ans') }}
</p>
<p class="text-secondary text-sm">{{ auth()->user()->email }}</p>
<div>
    @if(auth()->user()->role === 'patient')
        <a href="{{ route('myProfile') }}" type="button" class="btn bg-gradient-blue text-white btn-md">Modifier profil</a>
    @elseif(auth()->user()->role === 'doctor')
        <a href="#" type="button" class="btn bg-gradient-blue text-white btn-md">Contacter</a>
    @endif
</div>
</div>
