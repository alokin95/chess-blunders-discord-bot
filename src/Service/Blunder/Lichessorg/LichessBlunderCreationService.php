<?php

namespace App\Service\Blunder\Lichessorg;

use App\DTO\LichessBlunder;
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
        /** @var LichessBlunder $lichessBlunder */
        $lichessBlunder = $this->getBlunder->getBlunder();

        $blunderEntity = new Blunder();
        $blunderEntity->setBlunderId($lichessBlunder->getBlunderId());
        $blunderEntity->setElo($lichessBlunder->getRating());
        $blunderEntity->setSolution($lichessBlunder->getStandardNotationSolution());
        $blunderEntity->setBlunderProvider(BlunderProvider::Lichess->value);
        $blunderEntity->setFen($lichessBlunder->getFenAfterBlunderMove());
        $blunderEntity->setBlunderMove($lichessBlunder->getBlunderMove());
        $blunderEntity->setToPlay($this->fenFormatService->getColorToPlayFromFen($lichessBlunder->getFenAfterBlunderMove()));

        if (null != $this->checkIfBlunderAlreadyExists($blunderEntity))
        {
            $this->createBlunder();
        }

        entityManager()->persist($blunderEntity);
        entityManager()->flush();

        return $blunderEntity;
    }

//    /**
//     * @throws OptimisticLockException
//     * @throws ORMException
//     */
//    public function createBlunder(): Blunder
//    {
//        $blunderApi = $this->getBlunder->getBlunder();
//        $pgn = $blunderApi['game']['pgn'];
//        $blunderMove = explode(" ", $pgn);
//        $fen = PgnToFenConverterService::getFenFromPgn($pgn);
//
//        $blunderApi = $blunderApi['puzzle'];
//
//        $blunderEntity = new Blunder();
//        $blunderEntity->setBlunderId($blunderApi['id']);
//        $blunderEntity->setElo($blunderApi['rating']);
//        $blunderEntity->setSolution($blunderApi['solution']);
//        $blunderEntity->setBlunderProvider(BlunderProvider::Lichess->value);
//        $blunderEntity->setFen($fen);
//        $blunderEntity->setBlunderMove(end($blunderMove));
//        $blunderEntity->setToPlay($this->fenFormatService->getColorToPlayFromFen($fen));
//
//        if (null != $this->checkIfBlunderAlreadyExists($blunderEntity))
//        {
//            $this->createBlunder();
//        }
//
//        entityManager()->persist($blunderEntity);
//        entityManager()->flush();
//
//        return $blunderEntity;
//    }
}