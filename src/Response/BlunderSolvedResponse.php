<?php


namespace App\Response;


class BlunderSolvedResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        $this->message->author->sendMessage("Congratulations! You've solved the blunder!");
    }
}