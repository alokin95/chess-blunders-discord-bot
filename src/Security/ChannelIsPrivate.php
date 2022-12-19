<?php

namespace App\Security;

use App\Exception\WrongChannelException;
use App\Service\Command\AbstractCommand;
use Discord\Parts\Channel\Message;

class ChannelIsPrivate implements SecurityInterface
{
    private Message $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @throws WrongChannelException
     */
    public function denyAccessUnlessGranted(AbstractCommand $command)
    {
        if (!$this->message->channel->is_private)
        {
            throw new WrongChannelException($this->message, $command);
        }
    }
}