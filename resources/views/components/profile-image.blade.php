<img class="avatar avatar-xl border-radius-section shadow-sm"
     src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/default-profile.jpg') }}"
     alt="Profile Photo">


