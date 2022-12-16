<?php


namespace App\Response;


use App\Service\Command\AbstractCommand;
use Exception;

class BlunderAlreadyResignedResponse extends AbstractResponse
{
    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $this->message->author->sendMessage($this->message->author->username . ', don\'t embarrass yourself, you\'ve already resigned this blunder.');
    }
}