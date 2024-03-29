<?php

namespace App\Service\Blunder\Lichessorg;

use App\DTO\LichessBlunder;
use App\Entity\Enum\BlunderProvider;
use App\Repository\APIBlunderRepository;
use App\Repository\BlunderRepository;
use App\Request\LichessRequest;
use App\Service\Blunder\GetBlunderInterface;
use App\Service\Fen\FenFormatService;
use App\Service\Fen\PgnToFenConverterService;
use Exception;
use GuzzleHttp\Exception\GuzzleException;
use PChess\Chess\Chess;

class LichessRandomGetBlunderService implements GetBlunderInterface
{
    private LichessRequest $lichessRequest;
    private FenFormatService $fenFormatService;
    private BlunderRepository $blunderRepository;

    private APIBlunderRepository $APIBlunderRepository;

    public function __construct()
    {
        $this->lichessRequest = new LichessRequest();
        $this->fenFormatService = new FenFormatService();
        $this->blunderRepository = new BlunderRepository();
        $this->APIBlunderRepository = new APIBlunderRepository();
    }

    /**
     * @throws GuzzleException
     */
    public function getBlunder(bool $readFromFile = true): LichessBlunder
    {
        $lichessBlunder = $this->getBlunderFromSource($readFromFile);

        //TODO Fix this so it can use Lichess REST API
        //$fen = PgnToFenConverterService::getFenFromPgn($blunder['game']['pgn']);

        $isEnPassant = $this->fenFormatService->isEnPassantAvailable($lichessBlunder->getFenAfterBlunderMove());

        if ($isEnPassant) {
            return $this->getBlunder();
        }

        return $lichessBlunder;
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function getBlunderFromSource(bool $readFromFile = true): LichessBlunder
    {
        //TODO Fix this so it can use Lichess REST API
        $readFromFile = true;

        if (!$readFromFile) {
            return $this->lichessRequest->getRandomBlunder();
        }

        $data = $this->APIBlunderRepository->getRandomBlunder();

        if (!$data) {
            $this->getBlunderFromSource($readFromFile);
        }

        $lichessBlunder = $this->mapToDto(json_decode($data[0]['data']));

        //If this blunder is already in the database, then call the method again
        if ($this->blunderRepository->findOneBy(
            [
                'blunderId' => $lichessBlunder->getBlunderId(),
                'blunderProvider' => BlunderProvider::Lichess->value
            ])
        ) {
            $this->getBlunderFromSource($readFromFile);
        }

        //Make first move, because first element in the solution array is the starting position of the blunder
        $chessGame = new Chess($lichessBlunder->getFenBeforeBlunderMove());
        $chessGame = $this->makeFirstMove($chessGame, $lichessBlunder->getUnformattedSolution()[0]);
        $lichessBlunder->setFenAfterBlunderMove($chessGame->fen());
        $lichessBlunder->setBlunderMove($lichessBlunder->getUnformattedSolution()[0]);

        $lichessBlunder->setStandardNotationSolution($this->convertMovesToStandardNotation($chessGame, $lichessBlunder->getUnformattedSolution()));

        return $lichessBlunder;
    }

    /**
     * FEN is the position before the opponent makes their move.
     * The position to present to the player is after applying the first move to that FEN.
     * The second move is the beginning of the solution.
     *
     * @see https://database.lichess.org/#puzzles
     *
     * @throws Exception
     */
    private function makeFirstMove(Chess $chessGame, string $move): Chess
    {
        $move = str_split($move, 2);
        $promotion = count($move) === 3 ? $move[2] : null;

        return LichessBlunderHelperService::makeMove($chessGame, null, $move[0], $move[1], $promotion);
    }

    private function convertMovesToStandardNotation(Chess $chessGame, array $solutionArray): array
    {
        $standardNotationSolution = [];

        for ($i = 1; $i < count($solutionArray); $i++) {
            $move = str_split($solutionArray[$i], 2);
            $promotion = count($move) === 3 ? $move[2] : null;

            $standardNotationSolution[] = $chessGame->move(
                [
                    'from'      => $move[0],
                    'to'        => $move[1],
                    'promotion' => $promotion
                ]
            )->san;
        }

        return $standardNotationSolution;
    }

    private function mapToDto(array $data): LichessBlunder
    {
        $lichessBlunder = new LichessBlunder();

        $lichessBlunder->setBlunderId($data[0]);
        $lichessBlunder->setFenBeforeBlunderMove($data[1]);
        $lichessBlunder->setUnformattedSolution(explode(" ", $data[2]));
        $lichessBlunder->setRating($data[3]);

        return $lichessBlunder;
    }
}