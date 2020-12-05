<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Service\Blunder\AbstractBlunderCreationService;
use App\Service\Blunder\BlunderInterface;
use App\Service\FenFormatService;

class BlunderCreationService extends AbstractBlunderCreationService
{

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

        if (null != $this->checkIfBlunderAlreadyExists($blunderEntity))
        {
            $this->createBlunder();
        }

        entityManager()->persist($blunderEntity);
        entityManager()->flush();

        return $blunderEntity;
    }
}