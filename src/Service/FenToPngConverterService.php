<?php

namespace App\Service;

class FenToPngConverterService
{
    public function convert(string $fen)
    {
        return 'http://www.fen-to-image.com/image/100/' . $fen;
    }
}