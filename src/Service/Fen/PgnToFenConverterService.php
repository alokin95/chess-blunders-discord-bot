<?php

namespace App\Service\Fen;

use Onspli\Chess\PGN;

class PgnToFenConverterService
{
    public static function getFenFromPgn(string $pgn): ?string
    {
        $pgn = new PGN($pgn);

        return $pgn->get_current_fen();
    }
}