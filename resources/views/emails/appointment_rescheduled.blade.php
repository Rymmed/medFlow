@component('mail::message')
    # Demande de Report d'un rendez-vous

    {{ $appointment->patient->lastName }} {{ $appointment->patient->firstName }} a demandé de reporter son rendez-vous {{ $appointment->consultation_type }}
    initialement prévu le {{ \Carbon\Carbon::parse($oldDate)->format('d/m/Y') }}  à {{ \Carbon\Carbon::parse($oldDate)->format('H:i') }}
    à la nouvelle date: {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}

    Cordialement,
    {{ config('app.name') }}
@endcomponent
