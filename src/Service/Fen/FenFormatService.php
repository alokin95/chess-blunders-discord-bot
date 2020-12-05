<?php

namespace App\Service\Fen;

use Ryanhs\Chess\Chess;

class FenFormatService
{
    private $chessGame;

    public function __construct()
    {
        $this->chessGame = new Chess();
    }

    public function addBlunderMoveToFenPosition($fenBefore, $blunderMove)
    {
        $this->chessGame->load($fenBefore);
        $this->chessGame->move($blunderMove);

        return $this->chessGame->fen();
    }

    public function getColorToPlayFromFen(string $fen)
    {
        $colorToPlay = explode(" ", $fen)[1];

        if ('b' == strtolower($colorToPlay)) {
            return 'black';
        }

        return 'white';
    }
}