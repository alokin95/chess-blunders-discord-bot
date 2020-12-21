<?php

namespace App\Response;

use App\Service\Embed\CreateHelpEmbedMessageService;

class CommandHelpResponse extends AbstractResponse
{
    private $embedHelpService;

    public function __construct($message)
    {
        $this->embedHelpService = new CreateHelpEmbedMessageService();
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $embedHelp = $this->embedHelpService->createEmbed();
        $this->message->author->sendMessage('', false, $embedHelp);
    }
}