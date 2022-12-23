<?php

namespace App\Service\Blunder;

use App\Entity\Blunder;

class BlunderCreationServiceFactory
{
    public function __construct
    (
        private readonly AbstractBlunderCreationService $blunderCreationService
    )
    {}

    public function createBlunder(): Blunder
    {
        return $this->blunderCreationService->createBlunder();
    }
}