@component('mail::message')
    # Mise à jour du rendez-vous

    {{ $patient->firstName }} {{ $patient->lastName }} a demandé un rendez-vous {{ $appointment->consultation_type }}
    avec vous le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}

    Cordialement,
    {{ config('app.name') }}
@endcomponent
