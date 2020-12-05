<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Request\ChessBlundersRequest;
use App\Service\Blunder\BlunderInterface;

class RatedBlunderService implements BlunderInterface
{
    private $chessBlunderRequest;

    public function __construct()
    {
        $this->chessBlunderRequest = new ChessBlundersRequest();
    }
    public function getBlunder()
    {
        return $this->chessBlunderRequest->getRatedBlunder();
    }
}