<?php


namespace App\Response;


use Exception;

class BlunderAlreadySolvedResponse extends AbstractResponse
{
    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $this->message->author->sendMessage("Woah, hold your horses! You've already solved that blunder. Go play a Blitz game!");
    }
}