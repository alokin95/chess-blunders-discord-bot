<?php


namespace App\Service\Blunder;


use App\Entity\ChessGame;
use App\Request\ChessBlundersRequest;

class RatedBlunderService implements BlunderInterface
{
    private $chessBlunderRequest;

    public function __construct()
    {
        $this->chessBlunderRequest = new ChessBlundersRequest();
    }
    public function getBlunder(): ChessGame
    {
        $blunder = $this->chessBlunderRequest->getRatedBlunder();
    }
}