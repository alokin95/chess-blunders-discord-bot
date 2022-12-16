<?php

namespace App\Response;

use App\Entity\Blunder;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

class BlunderSolvedResponse extends AbstractResponse
{
    private Blunder $blunder;
    private int $numberOfTries;
    private ?\Discord\Discord $discordApp;

    public function __construct(Message $message, Blunder $blunder, int $numberOfTries)
    {
        $this->blunder          = $blunder;
        $this->numberOfTries    = $numberOfTries;
        $this->discordApp       = discordApp();
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $pluralize = $this->numberOfTries > 1 ? 'attempts' : 'attempt';
        $message = $this->message->author->username . ' has solved the blunder ' . $this->blunder->getId() . ' after ' . $this->numberOfTries . ' ' . $pluralize . '!';

        $this->discordApp->factory(Channel::class, [
            'id' => env('DISCORD_TEXT_CHANNEL_ID')
        ])->sendMessage($message);

        $this->message->author->sendMessage("Congratulations! You've solved the blunder!");
    }
}