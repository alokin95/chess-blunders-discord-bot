<?php

namespace App\Service\Statistic;

use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class UserStatisticService
{
    private SolvedBlunderRepository $solvedBlunderRepository;
    private ResignRepository $resignationRepository;
    private BlunderRepository $blunderRepository;

    public function __construct()
    {
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->resignationRepository        = new ResignRepository();
        $this->blunderRepository            = new BlunderRepository();
    }

    /**
     * @throws NonUniqueResultException
     * @throws Exception
     * @throws NoResultException
     */
    public function getUserStatistics($user): array
    {
        $solvedBlunders = $this->solvedBlunderRepository->countSolvedBlunders($user);
        $resignedBlunders = $this->resignationRepository->countResignedBlunders($user);
        $highestRatedSolved = $this->solvedBlunderRepository->getHighestRated($user);
        $lowestRatedResigned = $this->resignationRepository->getLowestRatedResigned($user);
        $averageNumberPerSolved = $this->solvedBlunderRepository->getAverageNumberOfAttempts($user);
        $averageNumberPerResign = $this->resignationRepository->getAverageNumberOfAttempts($user);
        $averageEloOfSolvedBlunders = $this->solvedBlunderRepository->getAverageEloOfSolvedBlunders($user);
        $averageEloOfResignedBlunders = $this->resignationRepository->getAverageEloOfResignedBlunders($user);
        $averageEloOfUnsolvedBlunders = $this->blunderRepository->getAverageEloOfUnsolvedBlunders($user);
        $unsolvedBlunders = $this->blunderRepository->countUnsolvedBlunders($user);

        return compact(
            'solvedBlunders',
            'resignedBlunders',
            'highestRatedSolved',
            'lowestRatedResigned',
            'averageNumberPerSolved',
            'averageNumberPerResign', 
            'averageEloOfSolvedBlunders',
            'averageEloOfResignedBlunders',
            'averageEloOfUnsolvedBlunders',
            'unsolvedBlunders'
        );
    }
}