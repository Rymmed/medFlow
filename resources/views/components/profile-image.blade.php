@props(['class'])
<img class="{{ $class }}"
     src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/default-profile.jpg') }}"
     alt="Profile Photo">
