<a href="javascript:;"
   class="btn btn-sm btn-icon-only bg-gradient-light mt-6 ms-n4"
   onclick="document.getElementById('profile_image_input').click();">
    <i class="fa fa-pen top-0" data-bs-toggle="tooltip" data-bs-placement="top"
       title="Modifier Photo"></i>
</a>
<!-- Formulaire de téléchargement caché -->
<form id="profile-image-form" action="{{ route('updateProfileImg') }}" method="POST"
      enctype="multipart/form-data" style="display:none;">
    @csrf
    @method('PUT')
    <input type="file" name="profile_image" id="profile_image_input"
           onchange="document.getElementById('profile-image-form').submit();">
</form>
