<?php


namespace App\Response;


class BlunderAlreadySolvedResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage("Woah, hold your horses! You've already solved that blunder. Go play a Blitz game!");
    }
}