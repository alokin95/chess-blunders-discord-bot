<?php

namespace App\Service\Command;

use App\Response\AbstractResponse;
use App\Service\Embed\CreateStatsBlunderMessageService;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Exception;
use Symfony\Component\Console\Command\HelpCommand;

class StatsCommand extends AbstractCommand
{
    private CreateStatsBlunderMessageService $statsEmbed;
    private ?Discord $discordApp;

    public function __construct(Message $message)
    {
        $this->discordApp             = discordApp();
        $this->statsEmbed       = new CreateStatsBlunderMessageService($message);
        parent::__construct($message);
    }

    /**
     * @throws Exception
     */
    public function execute(): AbstractResponse
    {
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