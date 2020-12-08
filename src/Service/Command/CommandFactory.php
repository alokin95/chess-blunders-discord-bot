<?php

namespace App\Service\Command;

class CommandFactory
{
    public function getCommandType($message)
    {
        $command = explode('#', $message->content)[1];

        $command = explode(" ", $command)[0];

        switch ($command)
        {
            case "solution":
                return new SolutionCommand($message);
            default:
                return new NonExistentCommand($message);
        }
    }
}