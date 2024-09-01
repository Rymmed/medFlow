@component('mail::message')
    # Annulation du rendez-vous

    {{ $appointment->patient->lastName }} {{ $appointment->patient->firstName }} a annulé son rendez-vous {{ $appointment->consultation_type }}
    prévu le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}

    Cordialement,
    {{ config('app.name') }}
@endcomponent
