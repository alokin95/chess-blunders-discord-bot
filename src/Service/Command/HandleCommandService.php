<?php

namespace App\Service\Command;

use Discord\Parts\Channel\Message;

class HandleCommandService
{
    private Message$message;
    private CommandFactory $messageFactory;

    public function __construct($message)
    {
        $this->message          = $message;
        $this->messageFactory   = new CommandFactory();
    }

    public function handle(): void
    {
        $command = $this->messageFactory->getCommandType($this->message);

        if (
            $command instanceof ShouldBeSentPrivatelyInterface
            && !$this->message->channel?->is_private
        ) {
//            $this->message->author->sendMessage('Please try again: ' . $this->message->content);
            $this->message->delete();
        }

        $command->execute();
    }
}