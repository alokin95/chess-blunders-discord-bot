<?php


namespace App\Exception;


use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Channel;

class WrongChannelException extends AbstractException
{
    protected function handle()
    {
        SendMessageService::sendTextMessage($this->message->channel, 'This type of message is allowed only when chatting directly with the Bot!');
    }
}