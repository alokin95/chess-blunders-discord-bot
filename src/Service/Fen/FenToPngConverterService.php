<?php

namespace App\Service\Fen;

class FenToPngConverterService implements FenConverterInterface
{
    private FenFormatService $fenFormatter;

    public function __construct()
    {
        $this->fenFormatter = new FenFormatService();
    }

    public function convert(string $fen): string
    {
        $colorToPlay = $this->fenFormatter->getColorToPlayFromFen($fen);
        $fen = explode(" ", $fen)[0];
        $png = 'https://chessboardimage.com/' . $fen;

        if ($colorToPlay === 'black') {
            $png.= '-flip';
        }

        return $png . '.png';
    }
}