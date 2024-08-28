@props(['appointments'])
<div class="card-header pb-0">
    <h5 class="mb-0">Rendez-Vous</h5>

</div>
<div class="card-body px-0 pt-0 pb-2">
    <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
            <thead>
            <tr>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Type
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Date
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Heure
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Rapport
                </th>
                <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">
                            <x-consultation-type-badge
                                :consultation_type="$appointment->consultation_type"></x-consultation-type-badge>
                        </p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('d M, Y') }}</p>
                    </td>
                    <td class="text-center">
                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}</p>
                    </td>
                    <td class="align-middle text-center text-sm">
                        <p class="text-xs font-weight-bold mb-0">{!! $appointment->consultationReport ? '<a href="' . route('consultationReport.show', $appointment->consultationReport->id) . '">Voir le rapport</a>' : '<a href="' . route('consultationReport.create', $appointment->id) . '">Créer</a>' !!}</p>
                    </td>
                    <td class="text-center">

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>
