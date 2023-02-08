<?php

namespace App\Service\Command;

use App\Entity\LichessAccount;
use App\Repository\LichessAccountRepository;
use App\Response\AbstractResponse;
use App\Response\CommandHelpResponse;
use App\Response\LichessUsernameAlreadyRegisteredResponse;
use App\Response\LichessUsernameUpdatedResponse;
use Discord\Parts\Channel\Message;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

class RegisterLichessAccountCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    private LichessAccountRepository $lichessAccountRepository;
    public function __construct
    (
        Message $message
    )
    {
        $this->lichessAccountRepository = new LichessAccountRepository();
        parent::__construct($message);
    }

    public static function getCommandName(): string
    {
        return 'Register Lichess account';
    }

    /**
     * #lichessRegister (username)
     *
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function execute(): AbstractResponse
    {
        $commandArray = explode(' ', $this->message->content);

        if (count($commandArray) != 2) {
            return new CommandHelpResponse($this->message);
        }

        $lichessUsername = $commandArray[1];

        $user = $this->message->author->id;

        if ($this->lichessAccountRepository->findOneBy(['lichessUsername' => $lichessUsername])) {
            return new LichessUsernameAlreadyRegisteredResponse($this->message);
        }

        if (!$lichessAccount = $this->lichessAccountRepository->findOneBy(['user' => $this->message->author->id])) {
            $lichessAccount = new LichessAccount();
        }

        $lichessAccount->setLichessUsername($lichessUsername);
        $lichessAccount->setUser($user);

        entityManager()->persist($lichessAccount);
        entityManager()->flush();

        return new LichessUsernameUpdatedResponse($this->message);
    }

    public function sendProperMessage(callable $callback): void
    {
        $callback();
    }
}