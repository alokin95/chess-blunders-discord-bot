<?php

namespace App\Exception;

use Exception;

class BlunderNotFoundException extends AbstractException
{
    protected function handle()
    {
        $blunderId = explode(" ", $this->discordMessage->content)[1];
        $this->discordMessage->author->sendMessage("The blunder with the id " . $blunderId . " was not found.");
    }
}