<?php

namespace App\Exception;

use Discord\Parts\Channel\Message;
use Exception;
use Throwable;

abstract class AbstractException extends Exception
{
    protected Message $discordMessage;

    public function __construct($discordMessage, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->discordMessage = $discordMessage;
        $this->handle();
    }

    protected abstract function handle();
}