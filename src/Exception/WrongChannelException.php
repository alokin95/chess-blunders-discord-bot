<?php


namespace App\Exception;


use App\Service\Command\AbstractCommand;
use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

class WrongChannelException extends AbstractException
{
    private AbstractCommand $abstractCommand;
    public function __construct
    (
        Message $message,
        AbstractCommand $command
    )
    {
        $this->abstractCommand = $command;
        parent::__construct($message);
    }
    protected function handle()
    {
        $this->discordMessage->author->getPrivateChannel()->then(function (Channel $channel) {
            SendMessageService::sendTextMessage(
                $this->abstractCommand::getCommandName()
                . ' is allowed only when chatting directly with the Bot! Please try again: '
                . $this->discordMessage->content,
                $channel
            );
        });
    }
}