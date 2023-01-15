<?php

namespace App\Request;

use App\Client\LichessClient;
use Doctrine\ORM\Cache\Exception\FeatureNotImplemented;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

class LichessRequest
{
    private LichessClient $client;

    public function __construct()
    {
        $this->client = new LichessClient();
    }

    /**
     * @throws GuzzleException
     */
    public function getRandomBlunder()
    {
        return $this->client->get('api/puzzle/daily');
    }

    /**
     * @throws Exception
     */
    public function getRatedBlunder()
    {
        throw new Exception('NOT IMPLEMENTED');
    }

    /**
     * @throws GuzzleException
     */
    public function getStatsByUsername(string $username)
    {
        return $this->client->get("api/user/$username");
    }
}