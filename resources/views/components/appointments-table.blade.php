@props(['appointments'])
<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                Date
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Type de Consultation
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Heure
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Rapport de consultation
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Status
            </th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Paiement
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
                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }}</p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $appointment->consultation_type }}</p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}</p>
                </td>
                <td class="align-middle text-center text-sm">
                    pas encore dev
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">{{ $appointment->status }}</p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">pas encore dev</p>
                </td>
                <td class="text-center">

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
