<?php


namespace App\Service\Blunder;


use App\Entity\Blunder;

class BlunderCreationService
{
    private $blunder;

    public function __construct(BlunderInterface $blunder)
    {
        $this->blunder = $blunder;
    }

    public function createBlunder()
    {
        $blunderApi = $this->blunder->getBlunder();
        $blunderApi = $blunderApi['data'];

        $blunderEntity = new Blunder();
        $blunderEntity->setBlunderId($blunderApi['id']);
        $blunderEntity->setElo($blunderApi['elo']);
        $blunderEntity->setBlunderMove($blunderApi['blunderMove']);
        $blunderEntity->setFen($blunderApi['fenBefore']);
        $blunderEntity->setToPlay($this->getColorToPlayFromFen($blunderApi['fenBefore']));
        $blunderEntity->setSolution($blunderApi['forcedLine']);

        return $blunderEntity;
    }

    private function getColorToPlayFromFen(string $fen)
    {
        $colorToPlay = explode(" ", $fen)[1];

        if ('b' == strtolower($colorToPlay)) {
            return 'black';
        }

        return 'white';
    }
}