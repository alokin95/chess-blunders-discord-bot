<?php


use Discord\Discord;

class DiscordConnection
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance()
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