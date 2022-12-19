<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Exception\BlunderNotFoundException;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\CommandHelpResponse;
use App\Response\SendSpecificBlunderResponse;
use Discord\Parts\Channel\Message;

class SendSpecificBlunderToUserCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    private BlunderRepository $blunderRepository;
    public function __construct(
        Message $message
    )
    {
        parent::__construct($message);
        $this->blunderRepository = new BlunderRepository();
    }

    public static function getCommandName(): string
    {
        return 'Show specific blunder';
    }

    /**
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

        return new SendSpecificBlunderResponse($this->message, $blunder);
    }
}