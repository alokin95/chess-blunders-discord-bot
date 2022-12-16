<?php

namespace App\Service\Command;

use App\Response\AbstractResponse;
use App\Response\UserStatisticResponse;
use App\Service\Embed\CreateStatsBlunderMessageService;
use Discord\Builders\MessageBuilder;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Exception;
use Symfony\Component\Console\Command\HelpCommand;

class StatsCommand extends AbstractCommand
{
    private CreateStatsBlunderMessageService $statsEmbed;

    public function __construct(Message $message)
    {
        $this->statsEmbed       = new CreateStatsBlunderMessageService($message);
        parent::__construct($message);
    }

    /**
     * @throws Exception
     */
    public function execute(): AbstractResponse
    {
        $embed = $this->statsEmbed->createEmbed();

        return new UserStatisticResponse($this->message, $embed);
    }
}