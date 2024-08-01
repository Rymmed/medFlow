<?php

namespace App\Services;

use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\RoomServiceClient;
use Exception;
use Livekit\Room;

class LiveKitService
{
    protected $client;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->client = new RoomServiceClient(env('LIVEKIT_URL'), env('LIVEKIT_API_KEY'), env('LIVEKIT_API_SECRET'));
    }

    public function createRoom($roomName): Room
    {
        return $this->client->createRoom($roomName);
    }

    /**
     * @throws Exception
     */
    public function generateToken($roomName, $userId, $isDoctor = false): string
    {
        $token = new AccessToken(env('LIVEKIT_API_KEY'), env('LIVEKIT_API_SECRET'), $roomName, $userId);
        if ($isDoctor) {
            $token->setOptions((new AccessTokenOptions())->setRoomAdmin());
        }
        return $token->toJwt();
    }
}
