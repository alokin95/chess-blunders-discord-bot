<?php

namespace App\Exception;

use Exception;
use Throwable;

abstract class AbstractException extends Exception
{
    protected $discordMessage;

    public function __construct($discordMessage, $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->discordMessage = $discordMessage;
        $this->handle();
    }

    protected abstract function handle();
}