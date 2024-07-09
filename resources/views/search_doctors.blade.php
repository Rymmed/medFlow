@extends('layouts.user_type.auth')

@section('content')
    <div class="row">
        <div class="container col-md-4 col-lg-3 card px-1">
{{--            <div class="card-header">--}}
                <h6 class="m-3">Trouver un médecin</h6>
{{--            </div>--}}
            <div class="card-body">
                <form action="{{ route('search_doctors') }}" method="POST" id="search-form">
                    @csrf
                    <div class="mb-3">
                        <label for="speciality">Spécialité :</label>
                        <select id="speciality" name="speciality[]" class="form-control" multiple>
                            @foreach(config('specialities') as $speciality)
                                <option value="{{ $speciality }}" {{ in_array($speciality, old('speciality', [])) ? 'selected' : '' }}>
                                    {{ $speciality }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="firstName">Prénom :</label>
                        <input type="text" id="firstName" name="firstName" class="form-control" value="{{ old('firstName', $firstName) }}">
                    </div>
                    <div class="mb-3">
                        <label for="lastName">Nom :</label>
                        <input type="text" id="lastName" name="lastName" class="form-control" value="{{ old('lastName', $lastName) }}">
                    </div>
                    <div class="mb-3">
                        <label for="country">Pays :</label>
                        <input type="text" id="country" name="country" class="form-control" value="{{ old('country', $country) }}">
                    </div>
                    <div class="mb-3">
                        <label for="city">Ville :</label>
                        <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $city) }}">
                    </div>
                    <button type="submit" class="btn btn-secondary right-0 " id="search-button">Rechercher</button>
                </form>
            </div>
        </div>
        <div id="search-results" class="container col-md-8 col-lg-9">
            <p class="mt-4 text-sm">Affichage de {{$results->count()}} parmis {{ $totalResults->count() }} résultats trouvés</p>
            <div class="card-body">
                <div class="row d-flex position-relative">
                    @if(isset($results) && $results->count() === 0)
                        <p>Aucun médecin trouvé.</p>
                    @elseif(isset($results))
                        <div class="row justify-content-center position-absolute">
                            @foreach($results as $doctor)
                                <div class="col-md-4 col-sm-5 mb-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-3 text-center">
                                                    <img class="avatar border-radius-section shadow" src="{{asset('assets/img/bruce-mars.jpg')}}" alt="doctor_photo">
                                                </div>
                                                <div class="col-9">
                                                    <h6 class="card-title">Dr. {{ $doctor->lastName }} {{ $doctor->firstName }}</h6>
                                                    <p class="card-text text-sm"><i class="fas fa-notes-medical mx-2"></i>{{ $doctor->speciality }}</p>
                                                </div>
                                            </div>
                                            <p class="card-text text-sm mt-3"><i class="fas fa-map-marker-alt mx-2"></i>{{ $doctor->city }} {{ $doctor->town }}</p>
                                            <p class="card-text text-sm"><i class="fas fa-phone-alt mx-2"></i>{{ $doctor->phone_number }}</p>
                                            <a href="{{ route('appointment.request', ['doctor_id' => $doctor->id]) }}" class="btn btn-primary">Prendre rendez-vous</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="d-flex justify-content-center my-5">
                            {{ $results->links() }}
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const specialitySelect = document.getElementById('speciality');
            const choices = new Choices(specialitySelect, {
                removeItemButton: true,
                placeholder: true,
                placeholderValue: 'Sélectionnez des spécialités',
                itemSelectText: 'Appuyer pour séléctionner',
                allowHTML: true,
            });
        });
    </script>
@endsection
