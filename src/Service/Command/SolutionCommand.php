<?php

namespace App\Service\Command;

use App\Entity\AttemptedSolution;
use App\Entity\Blunder;
use App\Entity\SolvedBlunder;
use App\Exception\BlunderNotFoundException;
use App\Exception\InvalidBlunderIdException;
use App\Repository\AttemptedSolutionRepository;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use App\Response\AbstractResponse;
use App\Response\BlunderAlreadySolvedResponse;
use App\Response\BlunderNotSolvedResponse;
use App\Response\BlunderSolvedResponse;
use App\Response\CommandHelpResponse;
use App\Response\NumberOfMovesDoesNotMatchResponse;
use App\Response\SendingSameSolutionTwiceResponse;
use App\Response\TryingToSolveAfterResignationResponse;
use App\Service\Message\SendMessageService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class SolutionCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    private BlunderRepository $blunderRepository;
    private AttemptedSolutionRepository $attemptedSolutionRepository;
    private SolvedBlunderRepository $solvedBlunderRepository;
    private ResignRepository $resignRepository;

    public function __construct($message)
    {
        $this->attemptedSolutionRepository  = new AttemptedSolutionRepository();
        $this->blunderRepository            = new BlunderRepository();
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->resignRepository             = new ResignRepository();
        parent::__construct($message);
    }

    /**
     * @throws BlunderNotFoundException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function execute(): AbstractResponse
    {
        $commandArray = explode(" ", $this->message->content);

        if (count($commandArray) <= 2)
        {
            return new CommandHelpResponse($this->message);
        }

        if (!is_numeric($commandArray[1])) {
            throw new InvalidBlunderIdException($this->message);
        }

        $blunder = $this->findBlunder($commandArray[1]);

        return $this->submitSolution($commandArray, $blunder);
    }

    /**
     * @throws BlunderNotFoundException
     */
    private function findBlunder(int $blunderId)
    {
        $blunder = $this->blunderRepository->find($blunderId);

        if (!$blunder) {
            throw new BlunderNotFoundException($this->message);
        }

        return $blunder;
    }

    /**
     * #solution (blunderId) (arrayOfMoves)
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function submitSolution(array $commandArray, Blunder $blunder): AbstractResponse
    {
        $submittedSolution = [];
        for ($i = 2; $i < count($commandArray); $i++)
        {
            $submittedSolution[] = $commandArray[$i];
        }

        if (count($submittedSolution) != count($blunder->getSolution())) {
            return new NumberOfMovesDoesNotMatchResponse($this->message);
        }

        if ($prematureResponse = $this->findPrematureResponse($blunder, $submittedSolution)) {
            return $prematureResponse;
        }

        $this->saveAttemptedSolution($blunder, $submittedSolution);

        if ($submittedSolution == $blunder->getSolution())
        {
            $this->saveSolution($blunder);

            $numberOfTries = $this->attemptedSolutionRepository->getNumberOfTries($this->message->author->id, $blunder);

            return new BlunderSolvedResponse($this->message, $blunder, $numberOfTries);
        }

        return new BlunderNotSolvedResponse($this->message, implode(' ', $submittedSolution));
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function saveSolution(Blunder $blunder)
    {
        $solvedBlunder = new SolvedBlunder();
        $solvedBlunder->setUser($this->message->author->id);
        $solvedBlunder->setBlunder($blunder);

        entityManager()->persist($solvedBlunder);
        entityManager()->flush();
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function saveAttemptedSolution(Blunder $blunder, array $submittedSolution)
    {
        $newSolution = new AttemptedSolution();
        $newSolution->setBlunder($blunder);
        $newSolution->setSubmittedSolution($submittedSolution);
        $newSolution->setUser($this->message->author->id);

        entityManager()->persist($newSolution);
        entityManager()->flush();
    }

    private function findPrematureResponse(Blunder $blunder, array $submittedSolution): ?AbstractResponse
    {
        //Send a message if blunder is already solved
        if ($this->solvedBlunderRepository->checkIfUserSolvedTheBlunder($blunder, $this->message->author->id))
        {
            return new BlunderAlreadySolvedResponse($this->message);
        }

        //Send a message that blunder is already resigned
        if ($this->resignRepository->getResignsByUserAndBlunder($this->message->author->id, $blunder)) {
            return new TryingToSolveAfterResignationResponse($this->message);
        }

        //Prevent sending the same solution multiple times
        /** @var AttemptedSolution[] $alreadySentSolutions */
        $alreadySentSolutions = $this->attemptedSolutionRepository->findBy(['user' => $this->message->author->id, 'blunder' => $blunder->getId()]);
        foreach ($alreadySentSolutions as $solution) {
            if ($solution->getSubmittedSolution() === $submittedSolution) {
                return new SendingSameSolutionTwiceResponse($this->message);
            }
        }

        return null;
    }

    public static function getCommandName(): string
    {
        return 'Solution command';
    }


    public function sendProperMessage(callable $callback): void
    {
        $content = $this->message->author . ' is trying to solve a blunder!';

        SendMessageService::sendTextMessage($content, null, $callback);
    }
}