<?php


namespace App\Service\Embed;


use Discord\Discord;

abstract class AbstractEmbed
{
    protected ?Discord $discord = null;

    public function __construct()
    {
        $this->discord = discordApp();
    }

    public abstract function createEmbed();
}