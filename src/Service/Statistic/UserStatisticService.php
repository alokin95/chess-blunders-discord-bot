<?php


namespace App\Service\Statistic;


use App\Repository\AttemptedSolutionRepository;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;

class UserStatisticService
{
    private $solvedBlunderRepository;
    private $attemptedSolutionRepository;
    private $resignationRepository;
    private $blunderRepository;

    public function __construct()
    {
        $this->attemptedSolutionRepository  = new AttemptedSolutionRepository();
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->resignationRepository        = new ResignRepository();
        $this->blunderRepository            = new BlunderRepository();
    }

    public function getUserStatistics($user)
    {
        $solvedBlunders = $this->solvedBlunderRepository->countSolvedBlunders($user);
        $resignedBlunders = $this->resignationRepository->countResignedBlunders($user);
        $highestRatedSolved = $this->solvedBlunderRepository->getHighestRated($user);
        $lowestRatedResigned = $this->resignationRepository->getLowestRatedResigned($user);
        $averageNumberPerSolved = $this->solvedBlunderRepository->getAverageNumberOfAttempts($user);
        $averageNumberPerResign = $this->resignationRepository->getAverageNumberOfAttempts($user);
        $averageEloOfSolvedBlunders = $this->solvedBlunderRepository->getAverageEloOfSolvedBlunders($user);
        $averageEloOfResignedBlunders = $this->resignationRepository->getAverageEloOfResignedBlunders($user);

        return compact(
            'solvedBlunders',
            'resignedBlunders',
            'highestRatedSolved',
            'lowestRatedResigned',
            'averageNumberPerSolved',
            'averageNumberPerResign', 
            'averageEloOfSolvedBlunders',
            'averageEloOfResignedBlunders'
        );
    }
}