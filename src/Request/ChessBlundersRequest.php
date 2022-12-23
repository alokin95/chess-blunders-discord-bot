<?php


namespace App\Request;


use App\Client\ChessBlundersClient;
use GuzzleHttp\Exception\GuzzleException;

class ChessBlundersRequest
{
    private ChessBlundersClient $client;

    public function __construct()
    {
        $this->client = new ChessBlundersClient();
    }

    /**
     * @throws GuzzleException
     */
    public function getRandomBlunder()
    {
        return $this->client->post('blunder/get', ['type' => 'explore']);
    }

    /**
     * @throws GuzzleException
     */
    public function getRatedBlunder()
    {
        return $this->client->post('blunder/get', [
            'type'  => 'rated',
            'token' => 'your-token' // TODO Add user token here.
        ]);
    }
}