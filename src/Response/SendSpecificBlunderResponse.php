<?php

namespace App\Response;

use App\Entity\Blunder;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Command\ShouldBeSentPrivatelyInterface;
use App\Service\Embed\CreateBlunderEmbedMessageService;
use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Message;

class SendSpecificBlunderResponse extends AbstractResponse implements ShouldBeSentPrivatelyInterface
{
    private Blunder $blunder;

    public function __construct
    (
        Message $message,
        Blunder $blunder
    )
    {
        $this->blunder = $blunder;
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $embed = new CreateBlunderEmbedMessageService($this->blunder);
        $embed = $embed->createEmbed();

        SendMessageService::replyToMessage($this->message, '', $embed);
    }
}