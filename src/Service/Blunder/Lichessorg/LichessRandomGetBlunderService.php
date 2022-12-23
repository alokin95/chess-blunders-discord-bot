<?php

namespace App\Service\Blunder\Lichessorg;

use App\Request\LichessRequest;
use App\Service\Blunder\GetBlunderInterface;
use App\Service\Fen\FenFormatService;
use App\Service\Fen\PgnToFenConverterService;
use GuzzleHttp\Exception\GuzzleException;

class LichessRandomGetBlunderService implements GetBlunderInterface
{
    private LichessRequest $lichessRequest;
    private FenFormatService $fenFormatService;

    public function __construct()
    {
        $this->lichessRequest = new LichessRequest();
        $this->fenFormatService = new FenFormatService();
    }

    /**
     * @throws GuzzleException
     */
    public function getBlunder()
    {
        $blunder = $this->lichessRequest->getRandomBlunder();

        $fen = PgnToFenConverterService::getFenFromPgn($blunder['game']['pgn']);

        $isEnPassant = $this->fenFormatService->isEnPassantAvailable($fen);

        if ($isEnPassant) {
            return $this->getBlunder();
        }

        return $blunder;
    }
}