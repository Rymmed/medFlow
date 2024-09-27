@extends('layouts.user_type.auth')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Section pour afficher les feedbacks des autres patients à gauche -->
            <div class="col-md-6">
                <h5>Avis des autres patients</h5>
                <div class="text-center">
                    <div class="rating-stars">
                        @php
                            $rating = $doctor->averageRating() ?? 0;  // Valeur par défaut 0 si aucune note
                            $fullStars = floor($rating); // Nombre d'étoiles pleines
                            $halfStar = $rating - $fullStars >= 0.5; // Étoile à moitié pleine ?
                        @endphp

                            <!-- Affichage des étoiles pleines -->
                        @for ($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star text-warning"></i>
                        @endfor

                        <!-- Affichage d'une étoile à moitié pleine -->
                        @if ($halfStar)
                            <i class="fas fa-star-half-alt text-warning"></i>
                        @endif

                        <!-- Affichage des étoiles vides -->
                        @for ($i = $fullStars + $halfStar; $i < 5; $i++)
                            <i class="far fa-star text-warning"></i>
                        @endfor

                        <p class="text-xs mt-2">Moyenne : {{ number_format($rating, 1) }} / 5</p>
                    </div>
                </div>
                @forelse ($feedbacks as $feedback)
                    <div class="card mb-2">
                        <div class="card-body">
                            <p>{{ $feedback->comment }}</p>
                            <small class="text-muted">Note : {{ $feedback->rating }} / 5</small>
                        </div>
                    </div>
                @empty
                    <p>Aucun avis pour le moment.</p>
                @endforelse

{{--                <!-- Section pour afficher la moyenne des notes -->--}}
{{--                @if ($averageRating)--}}
{{--                    <div class="alert alert-info mt-4">--}}
{{--                        <strong class="text-white">Moyenne des notes pour ce médecin : {{ $averageRating }} / 5</strong>--}}
{{--                    </div>--}}
{{--                @endif--}}
            </div>

            <!-- Formulaire pour laisser un feedback à droite -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Laisser un avis pour Dr. {{ $doctor->firstName }} {{ $doctor->lastName }}</h5>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success text-white">
                                {{ session('success') }}
                            </div>
                        @endif

                        <!-- Formulaire pour laisser un feedback -->
                        <form action="{{ route('feedback.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                            <input type="hidden" name="patient_id" value="{{ auth()->user()->id }}">

                            <div class="form-group">
                                <label for="comment">Votre avis</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
                            </div>

                            <div class="form-group text-right mt-3">
                                <button type="submit" class="btn btn-primary">Soumettre</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
