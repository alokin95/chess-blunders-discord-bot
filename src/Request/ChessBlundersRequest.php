<?php


namespace App\Request;


use App\Client\ChessBlundersClient;

class ChessBlundersRequest
{
    private ChessBlundersClient $client;

    public function __construct()
    {
        $this->client = new ChessBlundersClient();
    }

    public function getRandomBlunder()
    {
        return $this->client->post('blunder/get', ['type' => 'explore']);
    }

    public function getRatedBlunder()
    {
        return $this->client->post('blunder/get', [
            'type'  => 'rated',
            'token' => 'your-token' // TODO Add user token here.
        ]);
    }
}