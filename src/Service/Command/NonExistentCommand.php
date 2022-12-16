<?php

namespace App\Service\Command;

use App\Response\CommandHelpResponse;

class NonExistentCommand extends AbstractCommand
{
    public function execute(): CommandHelpResponse
    {
        return new CommandHelpResponse($this->message);
    }
}