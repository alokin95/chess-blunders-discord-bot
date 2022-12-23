<?php

namespace App\Client;

class ChessBlundersClient extends AbstractClient implements ClientInterface
{
    public function __construct()
    {
        $url = config('chess_blunders', 'url');
        parent::__construct($url);
    }
}