@if(auth()->user()->profile_image)
    <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile image"
         class="avatar avatar-xxl border-radius-section shadow-sm">
@else
    <img src="{{ asset('assets/img/default-profile.jpg') }}" alt="Default Profile image"
         class="avatar avatar-xxl border-radius-section shadow-sm">
@endif
<!-- Formulaire de téléchargement caché -->
<form id="profile-image-form" action="{{ route('updateProfileImg') }}" method="POST"
      enctype="multipart/form-data" style="display:none;">
    @csrf
    @method('PUT')
    <input type="file" name="profile_image" id="profile_image_input"
           onchange="document.getElementById('profile-image-form').submit();">
</form>
