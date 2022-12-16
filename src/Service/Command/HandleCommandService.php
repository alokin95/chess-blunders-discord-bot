<?php

namespace App\Service\Command;

class HandleCommandService
{
    private $message;
    private $messageFactory;

    public function __construct($message)
    {
        $this->message          = $message;
        $this->messageFactory   = new CommandFactory();
    }

    public function handle(): void
    {
        $command = $this->messageFactory->getCommandType($this->message);
        $command->execute();
    }
}