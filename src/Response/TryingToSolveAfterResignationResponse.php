<?php


namespace App\Response;


class TryingToSolveAfterResignationResponse extends AbstractResponse
{

    protected function sendResponse()
    {
        $this->message->author->sendMessage('Too little too late! Next time don\'t resign the blunder!');
    }
}