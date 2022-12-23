<?php

namespace App\Service\Blunder\Lichessorg;

use App\Entity\Blunder;
use App\Entity\Enum\BlunderProvider;
use App\Service\Blunder\AbstractBlunderCreationService;
use App\Service\Fen\PgnToFenConverterService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class LichessBlunderCreationService extends AbstractBlunderCreationService
{
    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createBlunder(): Blunder
    {
        $blunderApi = $this->getBlunder->getBlunder();
        $pgn = $blunderApi['game']['pgn'];
        $blunderMove = explode(" ", $pgn);
        $fen = PgnToFenConverterService::getFenFromPgn($pgn);

        $blunderApi = $blunderApi['puzzle'];

        $blunderEntity = new Blunder();
        $blunderEntity->setBlunderId($blunderApi['id']);
        $blunderEntity->setElo($blunderApi['rating']);
        $blunderEntity->setSolution($blunderApi['solution']);
        $blunderEntity->setBlunderProvider(BlunderProvider::Lichess->value);
        $blunderEntity->setFen($fen);
        $blunderEntity->setBlunderMove(end($blunderMove));
        $blunderEntity->setToPlay($this->fenFormatService->getColorToPlayFromFen($fen));

        if (null != $this->checkIfBlunderAlreadyExists($blunderEntity))
        {
            $this->createBlunder();
        }

        entityManager()->persist($blunderEntity);
        entityManager()->flush();

        return $blunderEntity;
    }
}