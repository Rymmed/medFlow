@props(['prescription'])
<div class="container">

    <h5 class="mb-2">Détails de l'Ordonnance</h5>


    <p><strong>Traitement:</strong> {{ $prescription->treatment }}</p>
    <p><strong>Description:</strong> {{ $prescription->description }}</p>

    <hr>

    <h5 class="mb-0">Lignes de l'Ordonnance</h5>


    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nom du
                    Médicament
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Dose</th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durée</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($prescription->prescriptionLines as $line)
                <tr>
                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $line->name }}</p></td>
                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $line->dose }}</p></td>
                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $line->duration }}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</div>
