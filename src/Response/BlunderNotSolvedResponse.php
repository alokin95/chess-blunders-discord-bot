<?php


namespace App\Response;


class BlunderNotSolvedResponse extends AbstractResponse
{

    protected function sendResponse()
    {
        $this->message->author->sendMessage('Error :(');
    }
}