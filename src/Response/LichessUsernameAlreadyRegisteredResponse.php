<?php

namespace App\Response;

class LichessUsernameAlreadyRegisteredResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage("That Lichess username is already registered.");
    }
}