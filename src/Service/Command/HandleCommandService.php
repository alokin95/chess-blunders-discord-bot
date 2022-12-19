<?php

namespace App\Service\Command;

use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Message;

class HandleCommandService
{
    private Message $message;
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
            SendMessageService::replyToMessage(
                $this->message,
                $command::getCommandName()
                . ' is allowed only when chatting directly with the Bot! Please try again: '
                . $this->message->content,
                null,
                function () {
                    $this->message->delete();
                }
            );
        }

        $command->execute();
    }
}