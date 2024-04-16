@extends('layouts.app')

@section('content')

    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome back</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Nom</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="Nom" name="lastName" id="lastName" aria-label="lastName" aria-describedby="lastName" value="{{ old('lastName') }}">
                                                    @error('nom')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Prénom</label>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="Prénom" name="firstName" id="firstName" aria-label="firstName" aria-describedby="firstName" value="{{ old('firstName') }}">
                                                    @error('prenom')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Email</label>
                                                <div class="mb-3">
                                                    <input type="email" class="form-control" name="email" id="email" placeholder="Entrer votre adresse email" aria-label="Email" aria-describedby="email-addon">
                                                    @error('email')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Mot de passe</label>
                                                <div class="mb-3">
                                                    <input type="password" class="form-control" name="password" id="password" placeholder="Entrer votre mot de passe" aria-label="Password" aria-describedby="password-addon">
                                                    @error('password')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Confirmer le mot de passe</label>
                                                <div class="mb-3">
                                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmer votre mot de passe" required autocomplete="new-password">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Date de naissance</label>
                                                <div class="mb-3">
                                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                                    @error('dob')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Numéro de téléphone</label>
                                                <div class="mb-3">
                                                    <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="Phone Number">
                                                    @error('phone_number')
                                                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                    @enderror
                                                </div>
                                                <label>Type de compte</label>
                                                <div class="mb-3">
                                                    <select id="role" class="form-control" name="role" required>
                                                        <option value="patient">Patient</option>
                                                        <option value="doctor">Médecin</option>
                                                    </select>
                                                </div>
                                                <div id="patientFields" class="specific-fields" style="display: none;">
                                                    <label for="cin_number">Numéro de CIN</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="cin_number" id="cin_number">
                                                        @error('cin_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <label for="insurance_number">Numéro d'assurance</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="insurance_number" id="insurance_number">
                                                        @error('insurance_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div id="doctorFields" class="specific-fields" style="display: none;">
                                                    <label for="speciality">Spécialité</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="speciality" id="speciality">
                                                        @error('speciality')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                    <label for="registration_number">Numéro d'inscription à l'ordre des médecins</label>
                                                    <div class="mb-3">
                                                        <input type="text" class="form-control" name="registration_number" id="registration_number">
                                                        @error('registration_number')
                                                        <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                                        @enderror
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign up</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <p class="mb-4 text-sm mx-auto">
                                        Already have an account?
                                        <a href="{{ route('login')}}" class="text-info text-gradient font-weight-bold">Sign in</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6" style="background-image:url('{{url('assets/img/curved-images/curved6.jpg')}}')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        document.getElementById('role').addEventListener('change', function() {
            var role = this.value;
            var patientFields = document.getElementById('patientFields');
            var doctorFields = document.getElementById('doctorFields');

            if (role === 'patient') {
                patientFields.style.display = 'block';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = true;
                });
                doctorFields.style.display = 'none';
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
            } else if (role === 'doctor') {
                patientFields.style.display = 'none';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
                doctorFields.style.display = 'block';
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = true;
                });
            } else {
                patientFields.style.display = 'none';
                doctorFields.style.display = 'none';
                patientFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
                doctorFields.querySelectorAll('input[required]').forEach(input => {
                    input.required = false;
                });
            }
        });
    </script>
@endsection
