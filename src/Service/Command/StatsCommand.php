<?php

namespace App\Service\Command;

use App\Service\Embed\CreateStatsBlunderMessageService;
use Discord\Parts\Channel\Channel;
use Symfony\Component\Console\Command\HelpCommand;

class StatsCommand extends AbstractCommand
{
    private $statsEmbed;
    private $discordApp;

    public function __construct($message)
    {
        $this->discordApp             = discordApp();
        $this->statsEmbed       = new CreateStatsBlunderMessageService($message);
        parent::__construct($message);
    }

    public function execute()
    {
        if ($this->message->content != '#stats') {
            return new HelpCommand();
        }

        $embed = $this->statsEmbed->createEmbed();

        if ($this->message->channel_id == env('DISCORD_TEXT_CHANNEL_ID'))
        {
           return $this->discordApp->factory(Channel::class, [
                'id' => env('DISCORD_TEXT_CHANNEL_ID')
            ])->sendMessage('', false, $embed);
        }

        $this->message->author->sendMessage('', false, $embed);
    }
}