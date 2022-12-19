<?php


namespace App\Service\Command;


use Discord\Parts\Channel\Message;

abstract class AbstractCommand implements CommandInterface
{
    protected Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public static abstract function getCommandName(): string;
}