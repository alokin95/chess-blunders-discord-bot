<?php

namespace App\Response;

use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Message;

class SolvedBlundersIdsResponse extends AbstractResponse
{
    private string $responseContent;

    public function __construct
    (
        Message $message,
        string $responseContent
    )
    {
        $this->responseContent = $responseContent;
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        SendMessageService::replyToMessage($this->message, $this->responseContent);
    }
}