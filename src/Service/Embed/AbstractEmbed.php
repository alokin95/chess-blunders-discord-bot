<?php


namespace App\Service\Embed;


abstract class AbstractEmbed
{
    protected $discord;

    public function __construct()
    {
        $this->discord = discordApp();
    }

    public abstract function createEmbed();
}