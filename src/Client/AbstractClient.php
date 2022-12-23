<?php

namespace App\Client;

use BadMethodCallException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AbstractClient
{
    protected string $url;
    protected Client $client;

    public function __construct
    (
        string $url
    )
    {
        $this->url = $url;
        $this->client = new Client([
            'base_uri' => $this->url
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function get(string $url, array $query = [], array $headers = [])
    {
        if (!array_key_exists('content-type', array_map('strtolower', $headers))) {
            $headers = [
                'Content-Type' => 'application/json'
            ];
        }

        $url = trim($url, '/');

        $request = $this->client->request(
            'GET',
            $url,
            [
                'headers'   => $headers
            ]
        );

        return json_decode($request
            ->getBody()
            ->getContents(), true);
    }

    /**
     * @throws GuzzleException
     */
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