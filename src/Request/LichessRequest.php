<?php

namespace App\Request;

use App\Client\LichessClient;
use Doctrine\ORM\Cache\Exception\FeatureNotImplemented;
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
     * @throws GuzzleException
     * @throws \Exception
     */
    public function getRatedBlunder()
    {
        throw new \Exception('NOT IMPLEMENTED');
    }
}