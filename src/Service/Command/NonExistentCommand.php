<?php


namespace App\Service\Command;


class NonExistentCommand extends AbstractCommand
{

    public function execute()
    {
        echo "The command does not exist";
    }
}