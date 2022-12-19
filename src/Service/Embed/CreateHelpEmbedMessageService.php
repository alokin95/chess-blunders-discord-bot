<?php

namespace App\Service\Embed;

use App\Entity\Blunder;
use App\Service\Fen\FenToPngConverterService;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Embed\Image;

class CreateHelpEmbedMessageService extends AbstractEmbed
{
    public function createEmbed(): Embed
    {
        $embed  = new Embed($this->discord);

        $embed->fill([
            'title'         => 'Chess Blunders',
            'description'   => 'Available commands',
            'fields'        => $this->createCustomFields()
        ]);

        return $embed;
    }

    private function createCustomFields(): array
    {
        $solution   = new Field($this->discord);
        $resign     = new Field($this->discord);
        $stats      = new Field($this->discord);
        $unsolved   = new Field($this->discord);
        $blunder    = new Field($this->discord);
        $help       = new Field($this->discord);

        $solution->fill([
            'name'  => "#solution [blunderID] [moves]",
            'value' => "*Submit the solution for the blunder*\n```[blunderID] - ID of the blunder\n[moves] - Chess valid moves separated by spaces```"
        ]);

        $resign->fill([
            'name'  => "#resign [blunderID]",
            'value' => "*Give up solving the blunder and see the solution*\n```[blunderID] - ID of the blunder```"
        ]);

        $stats->fill([
            'name'  => "#stats",
            'value' => "*Shows the user stats*"
        ]);

        $unsolved->fill([
            'name'  => "#unsolved [orderBy (`elo`, `id`)]",
            'value' => "*See all your unsolved blunders. Send `elo` or `id` flag for ordering*\n```[blunderID] - ID of the blunder```"
        ]);

        $blunder->fill([
            'name'  => "#blunder [blunderID]",
            'value' => "*Send the desired blunder to direct message*\n```[blunderID] - ID of the blunder```"
        ]);

        $help->fill([
            'name'  => '#help',
            'value' => '*Show all bot commands*'
        ]);

        return [$solution, $resign, $blunder, $unsolved, $stats, $help];
    }
}