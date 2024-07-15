<p class="mt-4">Affichage de {{$results->count()}} résultats trouvés</p>
<div class="card-body">
    <div class="row">
            @if(isset($results) && $results->count() === 0)
                <p>Aucun médecin trouvé.</p>
            @elseif(isset($results))
                <div class="row">
                    @foreach($results as $doctor)
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Dr. {{ $doctor->lastName }} {{ $doctor->firstName }}</h6>
                                    <p class="card-text">{{ $doctor->specialty }}</p>
                                    <p class="card-text">{{ $doctor->city }}, {{ $doctor->country }}</p>
                                    <a href="{{ route('appointment.request', ['doctor_id' => $doctor->id]) }}" class="btn btn-primary">Prendre rendez-vous</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
    </div>
</div>
