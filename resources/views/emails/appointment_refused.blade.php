@component('mail::message')
    # Refus de la demande du rendez-vous

    Votre demande de rendez-vous {{ $appointment->consultation_type }} avec Dr.{{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }}
    le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} à {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }} est réfusée.

    Merci de nous faire confiance pour votre santé!

    Cordialement,
    {{ config('app.name') }}
@endcomponent
