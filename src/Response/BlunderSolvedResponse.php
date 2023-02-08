<?php

namespace App\Response;

use App\Entity\Blunder;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Message\SendMessageService;
use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

class BlunderSolvedResponse extends AbstractResponse
{
    private Blunder $blunder;
    private int $numberOfTries;
    private int $newRating;
    private ?Discord $discordApp;

    /**
     * @throws IntentException
     */
    public function __construct(Message $message, Blunder $blunder, int $numberOfTries, int $newRating)
    {
        $this->blunder          = $blunder;
        $this->numberOfTries    = $numberOfTries;
        $this->newRating        = $newRating;
        $this->discordApp       = discordApp();
        parent::__construct($message);
    }

    /**
     * @throws NoPermissionsException
     */
    protected function sendResponse()
    {
        $pluralize = $this->numberOfTries > 1 ? 'attempts' : 'attempt';
        $message =
            $this->message->author->username
            . ' has solved the blunder '
            . $this->blunder->getId()
            . ' after ' . $this->numberOfTries
            . ' ' . $pluralize
            . '! His new rating is now '
            . $this->newRating;

        SendMessageService::sendTextMessage($message);

        $this->message->author->sendMessage(
            "Congratulations! You've solved the blunder! Your new rating is now " . $this->newRating . '.'
        );
    }
}