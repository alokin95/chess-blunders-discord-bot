<?php

namespace App\Security;

use App\Exception\WrongChannelException;

class ChannelIsPrivate implements SecurityInterface
{
    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function denyAccessUnlessGranted()
    {
        if ($this->message->channel_id == env('DISCORD_TEXT_CHANNEL_ID'))
        {
            throw new WrongChannelException($this->message);
        }
    }
}