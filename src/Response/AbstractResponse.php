<?php


namespace App\Response;


use Discord\Parts\Channel\Message;

abstract class AbstractResponse
{
    protected Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
        $this->sendResponse();
    }

    protected abstract function sendResponse();
}