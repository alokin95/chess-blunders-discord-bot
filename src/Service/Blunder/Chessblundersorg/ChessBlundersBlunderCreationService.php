<?php

namespace App\Service\Blunder\Chessblundersorg;

use App\Entity\Blunder;
use App\Entity\Enum\BlunderProvider;
use App\Service\Blunder\AbstractBlunderCreationService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ChessBlundersBlunderCreationService extends AbstractBlunderCreationService
{

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createBlunder(): Blunder
    {
        $blunderApi = $this->blunder->getBlunder();
        $blunderApi = $blunderApi['data'];

        $blunderEntity = new Blunder();
        $blunderEntity->setBlunderId($blunderApi['id']);
        $blunderEntity->setElo($blunderApi['elo']);
        $blunderEntity->setBlunderMove($blunderApi['blunderMove']);
        $blunderEntity->setSolution($blunderApi['forcedLine']);
        $blunderEntity->setBlunderProvider(BlunderProvider::ChessBlunders->value);

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