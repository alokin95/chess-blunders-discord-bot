<?php

namespace App\Service\Command;

use Discord\Parts\Channel\Message;

class CommandFactory
{
    public function getCommandType(Message $message): AbstractCommand
    {
        $messageContent = trim($message->content);

        $command = explode('#', $messageContent)[1];

        $command = explode(" ", $command)[0];

        return match ($command) {
            "solution"          => new SolutionCommand($message),
            "resign"            => new ResignCommand($message),
            "stats"             => new StatsCommand($message),
            "blunder"           => new SendSpecificBlunderToUserCommand($message),
            "unsolved"          => new SendUnsolvedBlunderIdsToUserCommand($message),
            "solved"            => new SendSolvedBlunderIdsToUserCommand($message),
            "resigned"          => new SendResignedBlunderIdsToUserCommand($message),
            "lichessRegister"   => new RegisterLichessAccountCommand($message),
            "lichessStats"      => new LichessStatsCommand($message),
            default => new NonExistentCommand($message),
        };
    }
}