<?php

namespace App\Response;

use App\Service\Embed\CreateHelpEmbedMessageService;
use App\Service\Message\SendMessageService;

class CommandHelpResponse extends AbstractResponse
{
    private CreateHelpEmbedMessageService $embedHelpService;

    public function __construct($message)
    {
        $this->embedHelpService = new CreateHelpEmbedMessageService();
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $embedHelp = $this->embedHelpService->createEmbed();
        SendMessageService::sendEmbedMessage($this->message->channel, $embedHelp);
    }
}