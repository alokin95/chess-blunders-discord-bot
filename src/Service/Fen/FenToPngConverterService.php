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

        if ($blunder->getBlunderProvider() === BlunderProvider::Lichess->value) {
            $png.= '-' . substr($blunder->getBlunderMove(), 0, 4);
        }

        if ($colorToPlay === 'black') {
            $png.= '-flip';
        }

        return $png . '.png';
    }
}