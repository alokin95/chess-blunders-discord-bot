<?php


namespace App\Response;


use Exception;

class TryingToSolveAfterResignationResponse extends AbstractResponse
{

    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $this->message->author->sendMessage('Too little too late! Next time don\'t resign the blunder!');
    }
}