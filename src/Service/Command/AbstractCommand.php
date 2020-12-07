<?php


namespace App\Service\Command;


abstract class AbstractCommand implements CommandInterface
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}