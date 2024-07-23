@extends('layouts.user_type.auth')

@section('content')
        <div class="container-fluid">
            <div class="page-header min-height-300 border-radius-xl mt-4"
                 style="background-image: url('{{url('../assets/img/bg/pngtree.jpg')}}'); background-position-y: 50%;">
                <span class="mask bg-gradient-primary opacity-6"></span>
            </div>
                    <div class="card card-body blur shadow-blur mx-4 mt-n6">
                        <div class="row gx-4">
                            <div class="col-auto">
                                <div class="position-relative">
                                    <x-profile-image :class="'avatar avatar-xl border-opacity-100 border-radius-section shadow-card me-2'" :image="auth()->user()->profile_image"></x-profile-image>
                                    <x-edit-image-btn></x-edit-image-btn>
                                </div>
                            </div>
                            <div class="col-auto my-auto">
                                <div class="h-100">
                                    <h5 class="mb-1">
                                        {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 my-sm-auto ms-sm-auto me-sm-0 mx-auto mt-3">
                            <div class="nav-wrapper position-relative end-0">
                                <ul class="nav nav-pills nav-fill p-1 bg-transparent" role="tablist">
                                    <li class="nav-item">
                                        <a id="profile-tab" class="nav-link mb-0 px-0 py-1 active " data-bs-toggle="tab"
                                           href="javascript:;"
                                           role="tab" aria-controls="overview" aria-selected="true">
                                            <i class="fa fa-solid fa-address-card"></i>
                                            <span class="ms-0">{{ __('Informations Personnelles') }}</span>
                                        </a>
                                    </li>
                                    @if(auth()->user()->role === 'patient')
                                        <li class="nav-item">
                                            <a id="medicalRecord-tab" class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab"
                                               href="javascript:;" role="tab" aria-controls="teams" aria-selected="false">
                                                <i class="fa fa-solid fa-lock"></i>
                                                <span class="ms-1">{{ __('Dossier Médical') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                    @if(auth()->user()->role === 'doctor')
                                        <li class="nav-item">
                                            <a href="#availability-form" id="availability-tab"
                                               class="nav-link mb-0 px-0 py-1 " data-bs-toggle="tab" role="tab"
                                               aria-controls="teams" aria-selected="false">
                                                <i class="fa fa-solid fa-business-time"></i>
                                                <span class="ms-1">{{ __('Horaires') }}</span>
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
            <!-- Modal -->
{{--            <div class="modal fade" id="cropImageModal" tabindex="-1" role="dialog" aria-labelledby="cropImageModalLabel"--}}
{{--                 aria-hidden="true">--}}
{{--                <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--                    <div class="modal-content">--}}
{{--                        <div class="modal-header">--}}
{{--                            <h5 class="modal-title font-weight-normal" id="cropImageModalLabel">Rogner l'image</h5>--}}
{{--                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">--}}
{{--                                <span aria-hidden="true">&times;</span>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                        <div class="modal-body">--}}
{{--                            <div class="image-cropper-container">--}}
{{--                                <img id="image-to-crop" src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('assets/img/default-profile.jpg') }}" alt="Profile Photo"--}}
{{--                                     style="max-width: 100%;">--}}
{{--                            </div>--}}
{{--                            <form id="profile-image-form" action="{{ route('updateProfileImg') }}" method="POST" enctype="multipart/form-data"--}}
{{--                                  style="display:none;">--}}
{{--                                @csrf--}}
{{--                                @method('PUT')--}}
{{--                                <input type="file" name="profile_image" id="profile_image_input" style="display:none;">--}}
{{--                                <input type="hidden" name="cropped_image" id="cropped_image_input" style="display: ">--}}
{{--                            </form>--}}
{{--                        </div>--}}
{{--                        <div class="modal-footer">--}}
{{--                            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fermer</button>--}}
{{--                            <button type="button" class="btn bg-gradient-primary" id="crop-button">Rogner</button>--}}
{{--                            <button type="button" class="btn bg-gradient-primary" id="save-changes-button">Enregistrer les--}}
{{--                                modifications--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}


        </div>
        <div class="container-fluid py-4">
            <x-general-info :user="auth()->user()" :role="auth()->user()->role"></x-general-info>
            <x-security></x-security>
            <x-medical-record></x-medical-record>

        </div>

    <script>
        document.getElementById('profile-tab').addEventListener('click', function () {
            document.getElementById('medicalRecord-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'block';
            document.getElementById('profile-form').style.display = 'block';
        });

        document.getElementById('medicalRecord-tab').addEventListener('click', function () {
            document.getElementById('profile-form').style.display = 'none';
            document.getElementById('security-form').style.display = 'none';
            document.getElementById('medicalRecord-form').style.display = 'block';
        });

        document.addEventListener('DOMContentLoaded', function () {
            const image = document.getElementById('image-to-crop');
            const input = document.getElementById('profile_image_input');
            const croppedImageInput = document.getElementById('cropped_image_input');
            let cropper;

            // Initialize Cropper.js when the modal is shown
            $('#cropImageModal').on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 1,
            autoCropArea: 1,
        });
        });

            // Destroy Cropper.js instance when the modal is hidden
            $('#cropImageModal').on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

            document.getElementById('crop-button').addEventListener('click', function () {
            const canvas = cropper.getCroppedCanvas({
            width: 300,
            height: 300,
        });

            canvas.toBlob(function (blob) {
            const url = URL.createObjectURL(blob);
            const croppedImage = document.createElement('img');
            croppedImage.src = url;
            document.querySelector('.image-cropper-container').innerHTML = '';
            document.querySelector('.image-cropper-container').appendChild(croppedImage);

            // Save the blob into the hidden input
            croppedImageInput.value = blob;
        });
        });

            document.getElementById('save-changes-button').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('profile-image-form'));
            fetch('{{ route('updateProfileImg') }}', {
            method: 'POST',
            body: formData,
            headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
        }).then(response => response.json()).then(data => {
            console.log(data);
            // Handle success
        }).catch(error => {
            console.error(error);
            // Handle error
        });
        });

            input.addEventListener('change', function (e) {
            const files = e.target.files;
            if (files && files.length > 0) {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
            image.src = e.target.result;
            $('#cropImageModal').modal('show');
        };
            reader.readAsDataURL(file);
        }
        });

            // Trigger file input on button click
            document.querySelector('a[onclick="document.getElementById(\'profile_image_input\').click();"]').addEventListener('click', function () {
            input.click();
        });
        });
    </script>

@endsection
