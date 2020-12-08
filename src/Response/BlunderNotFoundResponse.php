<?php

namespace App\Response;

class BlunderNotFoundResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $blunderId = explode(" ", $this->message->content)[1];
        $this->message->author->sendMessage('The blunder with the id ' . $blunderId . ' was not found. Are you sure you are sending the right ID?');
    }
}