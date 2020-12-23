<?php


namespace App\Response;


class ResignAfterSolvedResponse extends AbstractResponse
{
    protected function sendResponse()
    {
        return $this->message->author->sendMessage("Psst! You've solved that blunder, no need to resign it!");
    }
}