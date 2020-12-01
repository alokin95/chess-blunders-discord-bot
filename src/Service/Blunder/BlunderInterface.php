<?php

namespace App\Service\Blunder;

use App\Entity\ChessGame;

interface BlunderInterface
{
    public function getBlunder() : ChessGame;
}