@component('mail::message')
    # Annulation du rendez-vous

    Dr.{{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }} a annulé votre rendez-vous {{ $appointment->consultation_type }}
    prévu le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }} à {{ \Carbon\Carbon::parse($appointment->finish_date)->format('H:i') }}

    Merci de nous faire confiance pour votre santé!

    Cordialement,
    {{ config('app.name') }}
@endcomponent
