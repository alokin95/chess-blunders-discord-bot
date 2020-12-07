<?php


namespace App\Service\Command;


class SolutionCommand extends AbstractCommand
{
    public function execute()
    {
        dd($this->message->content);
    }
}