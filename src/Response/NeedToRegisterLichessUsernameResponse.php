<?php

namespace App\Response;

class NeedToRegisterLichessUsernameResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage("
                You first need to register your Lichess username. 
                Use **#lichessRegister `yourUsername`** to register'
            ");
    }
}