<?php


namespace App\Response;


abstract class AbstractResponse
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
        $this->sendResponse();
    }

    protected abstract function sendResponse();
}