<?php

namespace App\Service;

use App\Entity\Blunder;

class CreateEmbedMessageService
{
    private $blunder;

    public function __construct(Blunder $blunder)
    {
        $this->blunder = $blunder;
    }

    public function createEmbed()
    {
        dd($this->blunder);
    }
}