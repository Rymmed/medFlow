<?php

return [
    'api_key' => env('LIVEKIT_API_KEY'),
    'secret' => env('LIVEKIT_SECRET_KEY'),
    'host' => env('LIVEKIT_URL', 'http://localhost:7880'), // Assurez-vous que l'hôte LiveKit est correct
];
