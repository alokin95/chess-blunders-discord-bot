<?php


use Discord\Discord;
use Discord\Exceptions\IntentException;

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
            ]);
        }

        return self::$instance;
    }
}