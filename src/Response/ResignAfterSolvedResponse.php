<?php


namespace App\Response;


use Exception;
use React\Promise\ExtendedPromiseInterface;

class ResignAfterSolvedResponse extends AbstractResponse
{
    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $this->message->author->sendMessage("Psst! You've solved that blunder, no need to resign it!");
    }
}