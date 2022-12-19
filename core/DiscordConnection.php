<?php


use Discord\Discord;
use Discord\Exceptions\IntentException;
use Discord\WebSockets\Intents;

class DiscordConnection
{
    private static ?Discord $instance = null;

    private function __construct()
    {}

    /**
     * @throws IntentException
     */
    public static function getInstance(): ?Discord
    {
        if (null == self::$instance)
        {
            self::$instance = new Discord([
                'token' => env('DISCORD_BOT_SECRET'),
                'loadAllMembers' => true,
                'intents' => Intents::getDefaultIntents() | Intents::GUILDS | Intents::GUILD_MEMBERS | Intents::GUILD_PRESENCES | Intents::MESSAGE_CONTENT
            ]);
        }

        return self::$instance;
    }
}