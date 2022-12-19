<?php

namespace App\Service\Channel;

use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\Parts\Channel\Channel;

class DiscordChannelFactory
{
    private static Discord $discord;

    /**
     * @throws IntentException
     */
    public static function createFromId(string $id): ?Channel
    {
        self::$discord = discordApp();

        return self::$discord->getChannel($id);
    }

    public static function getDefaultChannel(): Channel
    {
        self::$discord = discordApp();

        return self::$discord->getChannel(env('DISCORD_TEXT_CHANNEL_ID'));
    }
}