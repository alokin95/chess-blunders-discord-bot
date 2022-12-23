<?php

namespace App\Client;

class LichessClient extends AbstractClient implements ClientInterface
{
    public function __construct()
    {
        $url = config('lichess', 'url');
        parent::__construct($url);
    }
}