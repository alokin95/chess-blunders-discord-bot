<?php

namespace App\Exception;

use Exception;

class InvalidBlunderIdException extends AbstractException
{
    /**
     * @throws Exception
     */
    protected function handle()
    {
        $blunderId = explode(" ", $this->discordMessage->content)[1];
        $this->discordMessage->author->sendMessage("Please provide correct blunder ID.");
    }
}