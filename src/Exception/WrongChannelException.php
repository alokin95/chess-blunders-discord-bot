<?php


namespace App\Exception;


use Discord\Parts\Channel\Channel;

class WrongChannelException extends AbstractException
{
    protected function handle()
    {
        $discordApp = discordApp();

        $discordApp->factory(Channel::class, [
            'id' => env('DISCORD_TEXT_CHANNEL_ID')
        ])->sendMessage('This type of message is allowed only when chatting directly with the Bot!');
    }
}