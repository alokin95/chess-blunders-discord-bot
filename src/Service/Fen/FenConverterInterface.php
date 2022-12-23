<?php

namespace App\Service\Fen;

use App\Entity\Blunder;

interface FenConverterInterface
{
    public function convert(Blunder $blunder): string;
}