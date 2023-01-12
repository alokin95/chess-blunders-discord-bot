<?php

namespace App\Response;

use App\Service\Embed\AbstractEmbed;
use App\Service\Message\SendMessageService;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class UserStatisticResponse extends AbstractResponse
{
    private ?Embed $embed;
    private ?Discord $discordApp;

    public function __construct(Message $message, Embed $embed)
    {
        $this->embed = $embed;
        $this->discordApp = discordApp();
        parent::__construct($message);
    }
    protected function sendResponse()
    {
        SendMessageService::sendEmbedMessage($this->embed, $this->message->channel);
    }
}