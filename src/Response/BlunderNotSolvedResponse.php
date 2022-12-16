<?php


namespace App\Response;


use Exception;

class BlunderNotSolvedResponse extends AbstractResponse
{

    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $this->message->author->sendMessage('Whoops! Try again!');
    }
}