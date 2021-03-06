<?php

namespace App\Service\Command;

use App\Entity\AttemptedSolution;
use App\Entity\Blunder;
use App\Entity\SolvedBlunder;
use App\Exception\BlunderNotFoundException;
use App\Repository\AttemptedSolutionRepository;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use App\Response\BlunderAlreadySolvedResponse;
use App\Response\BlunderNotSolvedResponse;
use App\Response\BlunderSolvedResponse;
use App\Response\CommandHelpResponse;
use App\Response\TryingToSolveAfterResignationResponse;
use App\Security\ChannelIsPrivate;
use App\Security\CheckPermissionsTrait;

class SolutionCommand extends AbstractCommand
{
    use CheckPermissionsTrait;

    private $blunderRepository;
    private $attemptedSolutionRepository;
    private $solvedBlunderRepository;
    private $resignRepository;
    private $channelIsPrivate;

    public function __construct($message)
    {
        $this->attemptedSolutionRepository  = new AttemptedSolutionRepository();
        $this->blunderRepository            = new BlunderRepository();
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->resignRepository             = new ResignRepository();
        $this->channelIsPrivate             = new ChannelIsPrivate($message);
        parent::__construct($message);
    }

    public function execute()
    {
        $this->denyAccessUnless($this->channelIsPrivate);

        $commandArray = explode(" ", $this->message->content);

        if (count($commandArray) <= 2)
        {
            return new CommandHelpResponse($this->message);
        }

        $blunder = $this->findBlunder($commandArray[1]);

        return $this->submitSolution($commandArray, $blunder);
    }

    private function findBlunder(int $blunderId)
    {
        $blunder = $this->blunderRepository->find($blunderId);

        if (!$blunder) {
            throw new BlunderNotFoundException($this->message);
        }

        return $blunder;
    }

    /**
     * @param array $commandArray
     * @param Blunder $blunder
     * @return BlunderNotSolvedResponse|BlunderSolvedResponse|BlunderAlreadySolvedResponse|TryingToSolveAfterResignationResponse
     */
    private function submitSolution(array $commandArray, Blunder $blunder)
    {
        $submittedSolution = [];
        for ($i = 2; $i < count($commandArray); $i++)
        {
            $submittedSolution[] = $commandArray[$i];
        }

        if ($this->solvedBlunderRepository->checkIfUserSolvedTheBlunder($blunder, $this->message->author->id))
        {
            return new BlunderAlreadySolvedResponse($this->message);
        }

        if ($this->resignRepository->getResignsByUserAndBlunder($this->message->author->id, $blunder)) {
            return new TryingToSolveAfterResignationResponse($this->message);
        }

        $this->saveAttemptedSolution($blunder, $submittedSolution);

        if ($submittedSolution == $blunder->getSolution())
        {
            $this->saveSolution($blunder);

            $numberOfTries = $this->attemptedSolutionRepository->getNumberOfTries($this->message->author->id, $blunder);

            return new BlunderSolvedResponse($this->message, $blunder, $numberOfTries);
        }

        return new BlunderNotSolvedResponse($this->message);
    }

    private function saveSolution(Blunder $blunder)
    {
        $solvedBlunder = new SolvedBlunder();
        $solvedBlunder->setUser($this->message->author->id);
        $solvedBlunder->setBlunder($blunder);

        entityManager()->persist($solvedBlunder);
        entityManager()->flush();
    }

    private function saveAttemptedSolution(Blunder $blunder, array $submittedSolution)
    {
        $newSolution = new AttemptedSolution();
        $newSolution->setBlunder($blunder);
        $newSolution->setSubmittedSolution($submittedSolution);
        $newSolution->setUser($this->message->author->id);

        entityManager()->persist($newSolution);
        entityManager()->flush();
    }
}