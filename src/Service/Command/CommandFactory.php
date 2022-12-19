<?php

namespace App\Service\Command;

class CommandFactory
{
    public function getCommandType($message): AbstractCommand
    {
        $messageContent = trim($message->content);

        $command = explode('#', $messageContent)[1];

        $command = explode(" ", $command)[0];

        return match ($command) {
            "solution"  => new SolutionCommand($message),
            "resign"    => new ResignCommand($message),
            "stats"     => new StatsCommand($message),
            "blunder"   => new SendSpecificBlunderToUserCommand($message),
            "unsolved"  => new SendUnsolvedBlunderIdsToUserCommand($message),
            default => new NonExistentCommand($message),
        };
    }
}