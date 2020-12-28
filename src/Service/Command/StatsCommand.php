<?php

namespace App\Service\Command;

use App\Service\Embed\CreateStatsBlunderMessageService;
use App\Service\Statistic\UserStatisticService;
use Symfony\Component\Console\Command\HelpCommand;

class StatsCommand extends AbstractCommand
{
    private $statisticService;
    private $statsEmbed;

    public function __construct($message)
    {
        $this->statsEmbed       = new CreateStatsBlunderMessageService($message);
        parent::__construct($message);
    }

    public function execute()
    {
        if ($this->message->content != '#stats') {
            return new HelpCommand();
        }

        $embed = $this->statsEmbed->createEmbed();

        $this->message->author->sendMessage('', false, $embed);
    }
}