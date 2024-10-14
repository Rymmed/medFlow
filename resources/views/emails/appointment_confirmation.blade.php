@component('mail::message')
    # Confirmation de demande du rendez-vous

    Vous avez un rendez-vous {{ $appointment->consultation_type }} avec Dr.{{ $appointment->doctor->lastName }} {{ $appointment->doctor->firstName }}
    le {{ \Carbon\Carbon::parse($appointment->start_date)->format('d/m/Y') }} de {{ \Carbon\Carbon::parse($appointment->start_date)->format('H:i') }} à {{ \Carbon\Carbon::parse($appointment->finish_date)->format('H:i') }}

    Merci de nous faire confiance pour votre santé!

    Cordialement,
    {{ config('app.name') }}
@endcomponent
