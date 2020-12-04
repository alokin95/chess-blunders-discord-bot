<?php

namespace App\Service;

class FenToPngConverterService
{
    public function convert(string $fen)
    {
        $fen = explode(" ", $fen)[0];
        return 'http://www.fen-to-image.com/image/100/' . $fen;
    }
}