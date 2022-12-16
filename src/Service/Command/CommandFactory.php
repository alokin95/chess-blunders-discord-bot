<?php

namespace App\Service\Command;

class CommandFactory
{
    public function getCommandType($message): AbstractCommand
    {
        $messageContent = trim($message->content);

        $command = explode('#', $messageContent)[1];

        $command = explode(" ", $command)[0];

        switch ($command)
        {
            case "solution":
                return new SolutionCommand($message);
            case "resign":
                return new ResignCommand($message);
            case "stats":
                return new StatsCommand($message);
            case "help":
            default:
                return new NonExistentCommand($message);
        }
    }
}