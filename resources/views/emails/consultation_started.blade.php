@component('mail::message')
    # Consultation en ligne démarrée

    Le docteur a démarré la consultation.

    @component('mail::button', ['url' => $joinUrl])
        Rejoindre la consultation
    @endcomponent

    Merci de nous faire confiance pour votre santé!

    Cordialement,
    {{ config('app.name') }}
@endcomponent
