<?php

namespace App\Response;

class NumberOfMovesDoesNotMatchResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage(
            "It seems that you are sending the wrong number of moves... Check the blunder info!"
        );
    }
}