<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Entity\Resign;
use App\Exception\BlunderNotFoundException;
use App\Repository\AttemptedSolutionRepository;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use App\Response\AbstractResponse;
use App\Response\BlunderAlreadyResignedResponse;
use App\Response\BlunderResignedResponse;
use App\Response\CommandHelpResponse;
use App\Response\ResignAfterSolvedResponse;
use App\Service\Message\SendMessageService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ResignCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    private ResignRepository $resignRepository;
    private BlunderRepository $blunderRepository;
    private SolvedBlunderRepository $solvedBlunderRepository;
    private AttemptedSolutionRepository $attemptedSolutionRepository;

    public function __construct($message)
    {
        $this->resignRepository             = new ResignRepository();
        $this->blunderRepository            = new BlunderRepository();
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->attemptedSolutionRepository  = new AttemptedSolutionRepository();
        $this->message                      = $message;
        parent::__construct($message);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws BlunderNotFoundException
     */
    public function execute(): AbstractResponse
    {
        $commandArray = explode(' ', $this->message->content);

        if (count($commandArray) != 2) {
            return new CommandHelpResponse($this->message);
        }

        $blunderToResign = $commandArray[1];

        /** @var Blunder $blunder */
        $blunder = $this->blunderRepository->findOneBy(['id' => $blunderToResign]);

        if (!$blunder) {
            throw new BlunderNotFoundException($this->message);
        }

        $blunderAlreadySolvedByUser = $this->solvedBlunderRepository->checkIfUserSolvedTheBlunder($blunder, $this->message->author->id);

        if ($blunderAlreadySolvedByUser) {
            return new ResignAfterSolvedResponse($this->message);
        }

        $userAlreadyResigned = $this->resignRepository->getResignsByUserAndBlunder($this->message->author->id, $blunderToResign);

        if ($userAlreadyResigned) {
            return new BlunderAlreadyResignedResponse($this->message);
        }

        $this->saveResignation($blunder);
        $solution = $blunder->getSolution();

        $attempts = $this->attemptedSolutionRepository->getNumberOfTries($this->message->author->id, $blunder);

        return new BlunderResignedResponse($this->message, $blunder, $solution, $attempts);
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    private function saveResignation($blunder)
    {
        $resign = new Resign();
        $resign->setBlunder($blunder);
        $resign->setUser($this->message->author->id);

        entityManager()->persist($resign);
        entityManager()->flush();
    }

    public static function getCommandName(): string
    {
        return 'Resign command';
    }

    public function sendProperMessage(callable $callback): void
    {
        $callback();
    }
}