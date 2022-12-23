<?php

namespace App\Service\Fen;

use PChess\Chess\Chess;

class FenFormatService
{
    private Chess $chessGame;

    public function createChessGameFromFen(string $fen): Chess
    {
        $this->chessGame = new Chess($fen);

        return $this->chessGame;
    }

    public function addBlunderMoveToFenPosition(string $fenBefore, string $blunderMove): string
    {
        $this->createChessGameFromFen($fenBefore);
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

    public function isEnPassantAvailable(string $fen): bool
    {
        $enPassant = explode(" ", $fen);

        if ('-' == $enPassant[3]) {
            return false;
        }

        return true;
    }
}