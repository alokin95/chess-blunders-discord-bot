<?php

namespace App\Service;

use App\Entity\Blunder;
use App\Service\Fen\FenToPngConverterService;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Embed\Image;

class CreateHelpEmbedMessageService
{
    private $discord;

    public function __construct()
    {
        $this->discord = discordApp();

    }

    public function createEmbed()
    {
        $embed  = new Embed($this->discord);

        $embed->fill([
            'title'         => 'Chess Blunders',
            'description'   => 'Available commands',
            'fields'        => $this->createCustomFields()
        ]);

        return $embed;
    }

    private function createCustomFields()
    {
        $solution   = new Field($this->discord);
        $help       = new Field($this->discord);

        $solution->fill([
            'name'      => "#solution [blunderID] [moves]",
            'value'     => "*Submit the solution for the blunder*\n```[blunderID] - ID of the blunder\n[moves] - Chess valid moves separated by spaces```"
        ]);

        $help->fill([
            'name'  => '#help',
            'value' => 'Show all bot commands'
        ]);

        return [$solution, $help];
    }
}