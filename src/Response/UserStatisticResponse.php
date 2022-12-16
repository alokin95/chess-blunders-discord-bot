<?php

namespace App\Response;

use App\Service\Embed\AbstractEmbed;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class UserStatisticResponse extends AbstractResponse
{
    private Embed $embed;
    private ?Discord $discordApp;

    public function __construct(Message $message, Embed $embed)
    {
        parent::__construct($message);
        $this->embed = $embed;
        $this->discordApp             = discordApp();
    }
    protected function sendResponse()
    {
        if ($this->message->channel_id == env('DISCORD_TEXT_CHANNEL_ID'))
        {
            return $this->discordApp->factory(Channel::class, [
                'id' => env('DISCORD_TEXT_CHANNEL_ID')
            ])->sendMessage('', false, $this->embed);
        }

        $this->message->author->sendMessage('', false, $this->embed);
    }
}