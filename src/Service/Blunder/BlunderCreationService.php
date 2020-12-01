<?php


namespace App\Service\Blunder;


class BlunderCreationService
{
    private $blunder;

    public function __construct(BlunderInterface $blunder)
    {

        $this->blunder = $blunder;
    }

    public function createBlunder()
    {
        $blunder = $this->blunder->getBlunder();
    }
}