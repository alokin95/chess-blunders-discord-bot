<?php

namespace App\Security;

use App\Exception\WrongChannelException;
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
    public function denyAccessUnlessGranted()
    {
        if ($this->message->channel_id == env('DISCORD_TEXT_CHANNEL_ID'))
        {
            throw new WrongChannelException($this->message);
        }
    }
}