<img class="avatar avatar-xxl border-radius-section shadow-sm"
     src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/default-profile.jpg') }}"
     alt="Profile Photo">

<!-- Formulaire de téléchargement caché -->
<form id="profile-image-form" action="{{ route('updateProfileImg') }}" method="POST"
      enctype="multipart/form-data" style="display:none;">
    @csrf
    @method('PUT')
    <input type="file" name="profile_image" id="profile_image_input"
           onchange="document.getElementById('profile-image-form').submit();">
</form>
