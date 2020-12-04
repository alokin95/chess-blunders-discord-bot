<?php


namespace App\Service\Blunder;


use App\Entity\Blunder;
use App\Service\FenFormatService;

class BlunderCreationService
{
    private $blunder;
    private $fenFormatService;

    public function __construct(BlunderInterface $blunder)
    {
        $this->blunder = $blunder;
        $this->fenFormatService = new FenFormatService();
    }

    public function createBlunder()
    {
        $blunderApi = $this->blunder->getBlunder();
        $blunderApi = $blunderApi['data'];

        $blunderEntity = new Blunder();
        $blunderEntity->setBlunderId($blunderApi['id']);
        $blunderEntity->setElo($blunderApi['elo']);
        $blunderEntity->setBlunderMove($blunderApi['blunderMove']);
        $blunderEntity->setSolution($blunderApi['forcedLine']);

        $blunderAddedToFenPosition = $this->fenFormatService->addBlunderMoveToFenPosition($blunderApi['fenBefore'], $blunderApi['blunderMove']);
        $blunderEntity->setFen($blunderAddedToFenPosition);

        $blunderEntity->setToPlay($this->fenFormatService->getColorToPlayFromFen($blunderAddedToFenPosition));

        entityManager()->persist($blunderEntity);
        entityManager()->flush();

        return $blunderEntity;
    }
}