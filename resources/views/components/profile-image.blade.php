@props(['class', 'image'])

<img class="{{ $class }}"
     src="{{ $image ? asset('storage/' . $image) : asset('assets/img/default-profile.jpg') }}"
     alt="Profile Photo">
