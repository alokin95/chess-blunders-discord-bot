<?php

namespace App\Response;

class SendingSameSolutionTwiceResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage('That solution was not correct the first time you\'ve tried it.');
    }
}