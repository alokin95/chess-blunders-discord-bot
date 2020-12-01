<?php


namespace App\Service\Blunder;


class BlunderFactory
{
    /**
     * @var $blunder BlunderInterface
     */
    private $blunder;

    public function __construct(BlunderInterface $blunder)
    {
        $this->blunder = $blunder;
    }

    public function generateBlunder()
    {
        $this->blunder->getBlunder();
    }
}