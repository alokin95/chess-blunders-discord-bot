<?php

namespace App\Client;

use GuzzleHttp\Client;

class ChessBlundersClient implements ClientInterface
{
    private $url;
    private $client;

    public function __construct()
    {
        $this->url = config('chess_blunders', 'url');
        $this->client = new Client([
            'base_uri' => $this->url
        ]);
    }

    public function get(string $url, array $query = [], array $headers = [])
    {
        throw new \BadMethodCallException();
    }

    public function post(string $url, array $body = [], array $headers = [])
    {
        if (!array_key_exists('content-type', array_map('strtolower', $headers))) {
            $headers = [
                'Content-Type' => 'application/json'
            ];
        }

        $url = trim($url, '/');

        $request = $this->client->request(
            'POST',
            $url,
            [
                'json'      => $body,
                'headers'   => $headers
            ]
        );

        return json_decode($request
            ->getBody()
            ->getContents(), true);
    }
}