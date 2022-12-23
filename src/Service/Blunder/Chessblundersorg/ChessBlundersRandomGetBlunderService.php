<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Request\ChessBlundersRequest;
use App\Service\Blunder\GetBlunderInterface;
use App\Service\Fen\FenFormatService;

class ChessBlundersRandomGetBlunderService implements GetBlunderInterface
{
    private ChessBlundersRequest $chessBlundersRequest;
    private FenFormatService $fenFormatter;

    public function __construct()
    {
        $this->chessBlundersRequest = new ChessBlundersRequest();
        $this->fenFormatter         = new FenFormatService();
    }

    public function getBlunder()
    {
       $blunder = $this->chessBlundersRequest->getRandomBlunder();

       $isEnPassant = $this->fenFormatter->isEnPassantAvailable($blunder['data']['fenBefore']);

       if ($isEnPassant) {
           return $this->getBlunder();
       }

       return $blunder;
    }
}