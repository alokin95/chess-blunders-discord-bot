<?php

namespace App\Service\Fen;

use App\Entity\Blunder;
use App\Entity\Enum\BlunderProvider;

class FenToPngConverterService implements FenConverterInterface
{
    private FenFormatService $fenFormatter;

    public function __construct()
    {
        $this->fenFormatter = new FenFormatService();
    }

    public function convert(Blunder $blunder): string
    {
        $fen = $blunder->getFen();

        $colorToPlay = $this->fenFormatter->getColorToPlayFromFen($fen);
        $fen = explode(" ", $fen)[0];
        $png = config('boards', 'chessboards') . $fen;

        if ($colorToPlay === 'black') {
            $png.= '-flip';
        }

        if ($blunder->getBlunderProvider() === BlunderProvider::Lichess->value) {
            $png.= '-' . $blunder->getBlunderMove();
        }

        return $png . '.png';
    }
}