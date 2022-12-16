<?php

namespace App\Service\Embed;

use App\Entity\Blunder;
use App\Service\Fen\FenToPngConverterService;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Embed\Image;

class CreateBlunderEmbedMessageService extends AbstractEmbed
{
    private Blunder $blunder;
    private FenToPngConverterService $fenToPngConverter;

    public function __construct(Blunder $blunder, $discord)
    {
        $this->blunder              = $blunder;
        $this->fenToPngConverter    = new FenToPngConverterService();
        parent::__construct();
    }

    public function createEmbed(): Embed
    {
        $embed  = new Embed($this->discord);
        $image  = new Image($this->discord);

        $pngUrl = $this->fenToPngConverter->convert($this->blunder->getFen());

        $image->fill([
            'url' => $pngUrl
        ]);

        $embed->fill([
            'title'         => ucfirst($this->blunder->getToPlay()) . ' to play',
            'description'   => 'Find the forced line (' . $this->countTheMoves($this->blunder->getSolution()) . ')',
            'url'           => $pngUrl,
            'thumbnail'     => $image,
            'fields'        => $this->createCustomFields()
        ]);

        return $embed;
    }

    private function createCustomFields(): array
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
            'value' => '#solution ' . $this->blunder->getId() . ' Qxf7+ Kd8 Rd7#'
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

    private function countTheMoves(array $solution): string
    {
        return count($solution) === 1 ? '1 move' : count($solution) . ' moves';
    }
}