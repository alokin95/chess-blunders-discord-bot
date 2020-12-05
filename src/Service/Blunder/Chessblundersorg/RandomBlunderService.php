<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Request\ChessBlundersRequest;
use App\Service\Blunder\BlunderInterface;

class RandomBlunderService implements BlunderInterface
{
    private $chessBlundersRequest;

    public function __construct()
    {
        $this->chessBlundersRequest = new ChessBlundersRequest();
    }

    public function getBlunder()
    {
       return $this->chessBlundersRequest->getRandomBlunder();
    }
}