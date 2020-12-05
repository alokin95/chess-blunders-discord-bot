<?php

namespace App\Service\Fen;

interface FenConverterInterface
{
    public function convert(string $fen);
}