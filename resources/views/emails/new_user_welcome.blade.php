@component('mail::message')
    # Bonjour {{ $user->firstName }} {{ $user->lastName }},

    Voici vos informations de connexion :
    Email: {{ $user->email }}
    Mot de passe: {{ $user->password }}
    Vous pouvez maintenant vous connecter à votre compte.

    Merci et bienvenue !
    {{ config('app.name') }}
@endcomponent
