<?php


namespace App\Service\Command;


use App\Entity\Resign;
use App\Exception\BlunderNotFoundException;
use App\Repository\BlunderRepository;
use App\Repository\ResignRepository;
use App\Repository\SolvedBlunderRepository;
use App\Response\BlunderAlreadyResignedResponse;
use App\Response\BlunderAlreadySolvedResponse;
use App\Response\BlunderResignedResponse;
use App\Response\CommandHelpResponse;
use App\Response\ResignAfterSolvedResponse;
use Symfony\Component\Console\Command\HelpCommand;

class ResignCommand extends AbstractCommand
{
    private $resignRepository;
    private $blunderRepository;
    private $solvedBlunderRepository;

    public function __construct($message)
    {
        $this->resignRepository         = new ResignRepository();
        $this->blunderRepository        = new BlunderRepository();
        $this->solvedBlunderRepository  = new SolvedBlunderRepository();
        $this->message                  = $message;
        parent::__construct($message);
    }

    public function execute()
    {
        $commandArray = explode(' ', $this->message->content);

        if (count($commandArray) != 2) {
            return new CommandHelpResponse($this->message);
        }

        $blunderToResign = $commandArray[1];

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

        return new BlunderResignedResponse($this->message, $blunder, $solution);
    }

    private function saveResignation($blunder)
    {
        $resign = new Resign();
        $resign->setBlunder($blunder);
        $resign->setUser($this->message->author->id);

        entityManager()->persist($resign);
        entityManager()->flush();
    }
}