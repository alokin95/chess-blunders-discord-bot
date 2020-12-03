<?php

namespace App\Service;

class HandleIncomingMessageService
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        echo "{$this->message->author->username}: {$this->message->content}",PHP_EOL;
    }
}