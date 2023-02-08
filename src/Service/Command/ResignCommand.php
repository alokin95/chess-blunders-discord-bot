<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Entity\Resign;
use App\Entity\UserRating;
use App\Exception\BlunderNotFoundException;
use App\Repository\AttemptedSolutionRepository;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use App\Repository\UserRatingRepository;
use App\Response\AbstractResponse;
use App\Response\BlunderAlreadyResignedResponse;
use App\Response\BlunderResignedResponse;
use App\Response\CommandHelpResponse;
use App\Response\ResignAfterSolvedResponse;
use App\Service\Message\SendMessageService;
use App\Service\Rating\UserRatingService;
use Discord\Parts\Channel\Message;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ResignCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    private ResignRepository $resignRepository;
    private BlunderRepository $blunderRepository;
    private SolvedBlunderRepository $solvedBlunderRepository;
    private AttemptedSolutionRepository $attemptedSolutionRepository;
    private UserRatingRepository $userRatingRepository;
    private UserRatingService $userRatingService;

    public function __construct(Message $message)
    {
        $this->resignRepository             = new ResignRepository();
        $this->blunderRepository            = new BlunderRepository();
        $this->solvedBlunderRepository      = new SolvedBlunderRepository();
        $this->attemptedSolutionRepository  = new AttemptedSolutionRepository();
        $this->userRatingRepository         = new UserRatingRepository();
        $this->userRatingService            = new UserRatingService();
        $this->message                      = $message;
        parent::__construct($message);
    }

    /**
     * #resign (blunderId)
     *
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

        $newRating = $this->calculateRating($this->message->author->id, $blunder);
        $this->saveResignation($blunder);
        $solution = $blunder->getSolution();

        $attempts = $this->attemptedSolutionRepository->getNumberOfTries($this->message->author->id, $blunder);

        return new BlunderResignedResponse($this->message, $blunder, $solution, $attempts, $newRating->getRating());
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

    /**
     * @throws \Doctrine\ORM\Exception\ORMException
     */
    private function calculateRating(string $id, Blunder $blunder): UserRating
    {
        $numberOfTries = $this->attemptedSolutionRepository->getNumberOfTries($this->message->author->id, $blunder);

        if (!$userRating = $this->userRatingRepository->findOneBy(['user' => $id])) {
            $userRating = new UserRating();
            $userRating->setUser($id);
        }

        $newUserRating = $this->userRatingService->calculateUserRating(
            $userRating->getRating(),
            $blunder->getElo(),
            $this->userRatingService->getConstantByNumberOfTries($numberOfTries),
            false
        );

        $userRating->setRating($newUserRating);

        entityManager()->persist($userRating);

        return $userRating;
    }
}