<?php

namespace App\Service;

use App\Entity\Blunder;
use App\Service\Fen\FenToPngConverterService;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Embed\Image;

class CreateEmbedMessageService
{
    private $blunder;
    private $discord;
    private $fenToPngConverter;

    public function __construct(Blunder $blunder, $discord)
    {
        $this->blunder              = $blunder;
        $this->discord              = $discord;
        $this->fenToPngConverter    = new FenToPngConverterService();
    }

    public function createEmbed()
    {
        $embed  = new Embed($this->discord);
        $image  = new Image($this->discord);

        $pngUrl = $this->fenToPngConverter->convert($this->blunder->getFen());

        $image->fill([
            'url' => $pngUrl
        ]);

        $embed->fill([
            'title'         => 'See full image',
            'description'   => 'Find the best move for ' . $this->blunder->getToPlay(),
            'url'           => $pngUrl,
            'thumbnail'     => $image,
            'fields'        => $this->createCustomFields()
        ]);

        return $embed;
    }

    private function createCustomFields()
    {
        $blunderIdField         = new Field($this->discord);
        $solutionExampleField   = new Field($this->discord);
        $eloField               = new Field($this->discord);
        $boardEditorsField      = new Field($this->discord);

        $blunderIdField->fill([
            'name'      => 'BlunderID',
            'value'     => $this->blunder->getId()
        ]);

        $solutionExampleField->fill([
            'name'  => 'Solution Example',
            'value' => '#solution ' . $this->blunder->getId() . ' Kf3 h3 a4'
        ]);

        $eloField->fill([
            'name'  => 'ELO',
            'value' => $this->blunder->getElo()
        ]);

        $boardEditorsField = $this->createBoardEditorsField($boardEditorsField);

        return [$eloField, $blunderIdField, $solutionExampleField, $boardEditorsField];
    }

    private function createBoardEditorsField($boardEditorsField)
    {
        $lichessBoardUrl = config('boards', 'lichess') . '' . $this->blunder->getFen();
        $lichessBoardUrl = str_replace(" ", '_', $lichessBoardUrl);

        $boardEditorsField->fill([
            'name'  => 'Analysis',
            'value' => '[lichess.org](' . $lichessBoardUrl . ')'
        ]);

        return $boardEditorsField;
    }
}