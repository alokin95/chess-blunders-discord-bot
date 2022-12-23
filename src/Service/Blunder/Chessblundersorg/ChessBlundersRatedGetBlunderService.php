<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Request\ChessBlundersRequest;
use App\Service\Blunder\GetBlunderInterface;

class ChessBlundersRatedGetBlunderService implements GetBlunderInterface
{
    private ChessBlundersRequest $chessBlunderRequest;

    public function __construct()
    {
        $this->chessBlunderRequest = new ChessBlundersRequest();
    }
    public function getBlunder()
    {
        return $this->chessBlunderRequest->getRatedBlunder();
    }
}