<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Exception\BlunderNotFoundException;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\CommandHelpResponse;
use App\Response\SendSpecificBlunderResponse;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Image;

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

    public function sendProperMessage(callable $callback): void
    {
        $content = $this->message->author->username . ' is requesting a blunder.';
        $filepath = dirname(__DIR__ . '/..', 4) . '/assets/img/needMoreBlunder.jpg';
        $filename = 'needMoreBlunder.jpg';

        SendMessageService::sendMessageWithFile($content, $filepath, $filename);
        $callback();
    }
}