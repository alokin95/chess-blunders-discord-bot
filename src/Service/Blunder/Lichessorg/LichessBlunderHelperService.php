<?php

namespace App\Service\Blunder\Lichessorg;

use App\DTO\LichessBlunder;
use Exception;
use PChess\Chess\Chess;

class LichessBlunderHelperService
{
    /**
     * @throws Exception
     */
    public static function makeMove
    (
        Chess $chessGame,
        ?string $sanMove = null,
        ?string $moveFrom = null,
        ?string $moveTo = null
    ): Chess
    {
        if (!is_null($sanMove)) {
            $chessGame->move($sanMove);
            return $chessGame;
        }

        if (!is_null($moveFrom) && !is_null($moveTo)) {
            $chessGame->move(['from' => $moveFrom, 'to' => $moveTo]);
            return $chessGame;
        }

        throw new Exception("INVALID MOVES ---" . ' san: ' . $sanMove . ', from: ' . $moveFrom . ' to: ' . $moveTo);
    }

    public static function convertSolutionToStandardNotation(Chess $chessGame, array $standardNotationMoves): array
    {
        foreach ($standardNotationMoves as $key => $move) {
            $move = str_split($move, 2);

        }

        return [];
    }
}