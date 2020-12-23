<?php

namespace App\Response;

use Discord\Parts\Channel\Channel;

class BlunderSolvedResponse extends AbstractResponse
{
    private $blunder;
    private $numberOfTries;
    private $discordApp;

    public function __construct($message, $blunder, $numberOfTries)
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