<?php

namespace App\Services;

use Agence104\LiveKit\AccessToken;
use Agence104\LiveKit\AccessTokenOptions;
use Agence104\LiveKit\RoomCreateOptions;
use Agence104\LiveKit\RoomServiceClient;
use Agence104\LiveKit\VideoGrant;
use Exception;

class LiveKitService
{
    protected mixed $apiKey;
    protected mixed $apiSecret;
    protected mixed $livekitUrl;

    public function __construct()
    {
        $this->apiKey = env('LIVEKIT_API_KEY');
        $this->apiSecret = env('LIVEKIT_API_SECRET');
        $this->livekitUrl = env('LIVEKIT_URL');
    }

    /**
     * @throws Exception
     */
    public function createRoom(string $roomName)
    {
        $client = new RoomServiceClient($this->livekitUrl, $this->apiKey, $this->apiSecret);
        $client->createRoom((new RoomCreateOptions())->setName($roomName));

        return $roomName;
    }
    /**
     * @throws Exception
     */
    public function generateToken($roomName, $participantName)
    {
        $tokenOptions = (new AccessTokenOptions())->setIdentity($participantName);
        $videoGrant = (new VideoGrant())->setRoomJoin()->setRoomName($roomName);

        return (new AccessToken($this->apiKey, $this->apiSecret))
            ->init($tokenOptions)
            ->setGrant($videoGrant)
            ->toJwt();
    }

    public function getLivekitUrl()
    {
        return $this->livekitUrl;
    }
}
