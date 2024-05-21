@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <h4>Recherche de médecins</h4>
        <form action="{{ route('search_doctors') }}" method="POST" id="search-form">
            <div class="row">
                <div class="col-lg-2 mb-3">
                    <label for="speciality">Spécialité :</label>
                    <input type="text" id="speciality" name="speciality" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="city">Ville :</label>
                    <input type="text" id="city" name="city" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="country">Pays :</label>
                    <input type="text" id="country" name="country" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="firstName">Prénom :</label>
                    <input type="text" id="firstName" name="firstName" class="form-control">
                </div>
                <div class="col-lg-2 mb-3">
                    <label for="lastName">Nom :</label>
                    <input type="text" id="lastName" name="lastName" class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-outline-secondary" id="search-button">Rechercher</button>
        </form>
    </div>
    <div id="search-results" class="container">
        @include('partials.search_results')
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('search-form');
            const searchButton = document.getElementById('search-button');
            const searchResults = document.getElementById('search-results');

            searchButton.addEventListener('click', function(event) {
                event.preventDefault();

                const formData = new FormData(form);

                fetch('{{ route("search_doctors") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                    .then(response => response.text())
                    .then(data => {
                        searchResults.innerHTML = data;
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

@endsection
