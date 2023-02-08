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
        $solve              = new Field($this->discord);
        $resign             = new Field($this->discord);
        $stats              = new Field($this->discord);
        $solved             = new Field($this->discord);
        $resigned           = new Field($this->discord);
        $unsolved           = new Field($this->discord);
        $blunder            = new Field($this->discord);
        $lichessRegister    = new Field($this->discord);
        $lichessStats       = new Field($this->discord);
        $help               = new Field($this->discord);

        $solve->fill([
            'name'  => "#solve [blunderID] [moves]",
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

        $solved->fill([
            'name'  => "#solved (`elo`, `id`, `moves`) (`asc`, `desc`)",
            'value' => "*See all your solved blunders. Send `elo`,`id` or `moves` flag for ordering*"
        ]);

        $resigned->fill([
            'name'  => "#resigned (`elo`, `id`, `moves`) (`asc`, `desc`)",
            'value' => "*See all your resigned blunders. Send `elo`,`id` or `moves` flag for ordering*"
        ]);

        $unsolved->fill([
            'name'  => "#unsolved (`elo`, `id`, `moves`) (`asc`, `desc`)",
            'value' => "*See all your unsolved blunders. Send `elo`,`id` or `moves` flag for ordering*"
        ]);

        $blunder->fill([
            'name'  => "#blunder [blunderID]",
            'value' => "*Send the desired blunder to direct message*\n```[blunderID] - ID of the blunder```"
        ]);

        $lichessRegister->fill([
            'name'  => "#lichessRegister [lichessUsername]",
            'value' => "*Register Lichess username to the bot*\n```[lichessUsername] - Your Lichess username```"
        ]);

        $lichessStats->fill([
            'name'  => "#lichessStats",
            'value' => "*Brag with your Lichess stats!*\n"
        ]);

        $help->fill([
            'name'  => '#help',
            'value' => '*Show all bot commands*'
        ]);

        return [
            $solve,
            $resign,
            $blunder,
            $solved,
            $resigned,
            $unsolved,
            $stats,
            $lichessRegister,
            $lichessStats,
            $help];
    }
}