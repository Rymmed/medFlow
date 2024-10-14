@component('mail::message')
    # Annulation du rendez-vous

    Dr.{{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }} a annulé son rendez-vous {{ $appointment->consultation_type }} avec vous
    prévu le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }}

    Cordialement,
    {{ config('app.name') }}
@endcomponent
