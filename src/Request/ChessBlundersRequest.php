<?php


namespace App\Request;


use App\Client\ChessBlundersClient;

class ChessBlundersRequest
{
    private $client;

    public function __construct()
    {
        $this->client = new ChessBlundersClient();
    }

    public function getRandomBlunder()
    {
        return $this->client->post('blunder/get', ['type' => 'explore']);
    }
}