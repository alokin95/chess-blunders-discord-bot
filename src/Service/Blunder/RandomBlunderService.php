<?php


namespace App\Service\Blunder;


use App\Entity\ChessGame;
use App\Request\ChessBlundersRequest;

class RandomBlunderService implements BlunderInterface
{
    private $chessBlundersRequest;

    public function __construct()
    {
        $this->chessBlundersRequest = new ChessBlundersRequest();
    }

    public function getBlunder() : ChessGame
    {
       $blunder = $this->chessBlundersRequest->getRandomBlunder();
       $chessGame = new ChessGame();
    }
}