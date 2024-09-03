@foreach($patients as $patient)
    <tr>
        <td class="text-center">
            <x-profile-image :class="'avatar avatar-sm shadow-sm'" :image="$patient->profile_image"></x-profile-image>
        </td>
        <td class="text-center">
            <p class="mb-0 font-weight-bold text-xs">{{ $patient->lastName }} {{ $patient->firstName }}</p>
        </td>
        <td class="text-center">
            <p class="text-xs font-weight-bold mb-0">{{ $patient->email }}</p>
        </td>
        <td class="text-center">
            <p class="text-xs font-weight-bold mb-0">{{ $patient->phone_number ? : '---' }}</p>
        </td>
        <td class="text-center">
            <p class="text-xs font-weight-bold mb-0">@if($patient->gender === 0)
                    {{ __('Homme') }}
                @else
                    {{ __('Femme') }}
                @endif</p>
        </td>
        <td class="text-center">
            <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($patient->dob)->age }} {{ __('ans') }}</p>
        </td>
        <td class="text-center">
            @if(auth()->user()->role === 'doctor')
                <a href="{{ route('myPatient.record', ['patient_id' => $patient->id]) }}"
                   class="text-xs font-weight-bold mb-0 cursor-pointer text-blue">
                    Dossier médical
                </a>
            @else
                <a href="{{ route('doctor-patients.edit', $patient->id) }}"
                   data-bs-toggle="tooltip" data-bs-original-title="Modifier">
                    <i class="fa fa-user-edit text-blue me-2"></i>
                </a>
                <a data-bs-toggle="modal" data-bs-target="#createAppointmentModal-" id="add-appointment-btn-"
                   class="cursor-pointer" data-user-id="{{ $patient->id }}" data-user-name="{{ $patient->lastName }} {{ $patient->firstName }}">
                    <i class="fa fa-calendar-plus text-primary"></i>
                </a>
            @endif
        </td>
    </tr>
@endforeach

