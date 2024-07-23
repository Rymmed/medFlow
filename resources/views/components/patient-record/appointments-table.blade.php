@props(['appointments'])
<div class="table-responsive p-0">
    <table class="table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Médecin
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Type
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Date
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Heure
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Rapport
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Status
            </th>
            <th class="text-start text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        @foreach($appointments as $appointment)
            <tr>
                <td class="text-start">
                    <div class="d-flex px-2 py-1">
                        <div class="me-2">
                            <x-profile-image :class="'avatar avatar-sm shadow-sm'" :image="$appointment->doctor->profile_image"></x-profile-image>

                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-xs">Dr. {{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $appointment->doctor->doctor_info->speciality }}</p>
                        </div>
                    </div>
                </td>
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
                    <p class="text-xs font-weight-bold mb-0">{!! $appointment->consultationReport ? '<a href="' . route('consultationReport.show', $appointment->consultationReport->id) . '">Voir le rapport</a>' : '<span>---</span>' !!}</p>
                </td>
                <td class="text-center">
                    <p class="text-xs font-weight-bold mb-0">
                        <x-appointment-status-badge :status="$appointment->status"></x-appointment-status-badge>
                    </p>
                </td>
                <td class="text-center">

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
