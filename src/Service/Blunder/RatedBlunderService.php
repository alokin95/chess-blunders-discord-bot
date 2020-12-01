<?php


namespace App\Service\Blunder;


use App\Entity\ChessGame;
use App\Request\ChessBlundersRequest;

class RatedBlunderService implements BlunderInterface
{
    private $chessBlunderRequest;

    public function __construct(ChessBlundersRequest $chessBlunderRequest)
    {
        $this->chessBlunderRequest = $chessBlunderRequest;
    }
    public function getBlunder(): ChessGame
    {
        $blunder = $this->chessBlunderRequest->getRatedBlunder();
    }
}