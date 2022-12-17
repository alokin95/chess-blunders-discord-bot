<?php

namespace App\Service\Fen;

use PChess\Chess\Chess;

class FenFormatService
{
    private Chess $chessGame;

    public function addBlunderMoveToFenPosition($fenBefore, $blunderMove): string
    {
        $this->chessGame = new Chess($fenBefore);
        $this->chessGame->move($blunderMove);

        return $this->chessGame->fen();
    }

    public function getColorToPlayFromFen(string $fen): string
    {
        $colorToPlay = explode(" ", $fen)[1];

        if ('b' == strtolower($colorToPlay)) {
            return 'black';
        }

        return 'white';
    }

    public function isEnPassantAvailable($fen): bool
    {
        $enPassant = explode(" ", $fen);

        if ('-' == $enPassant[3]) {
            return false;
        }

        return true;
    }
}