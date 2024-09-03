@props(['class', 'image'])

<img class="{{ $class }}"
     src="{{ $image ? asset('storage/' . $image) : asset('assets/img/default-image.jpg') }}"
     alt="Profile Photo">
