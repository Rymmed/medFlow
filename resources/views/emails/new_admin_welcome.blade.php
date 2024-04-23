<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenue comme nouvel administrateur</title>
</head>
<body>
<p>Bonjour {{ $admin->firstName }} {{ $admin->lastName }},</p>

<p>Merci de vous être inscrit comme nouvel administrateur sur notre site.</p>

<p>Voici vos informations de connexion :</p>

<ul>
    <li><strong>Email:</strong> {{ $admin->email }}</li>
    <li><strong>Mot de passe:</strong> Votre mot de passe choisi lors de l'inscription est {{ $admin->password }}</li>
</ul>

<p>Vous pouvez maintenant vous connecter à votre compte administrateur et accéder aux fonctionnalités réservées aux administrateurs.</p>

<p>Merci et bienvenue !</p>
</body>
</html>
