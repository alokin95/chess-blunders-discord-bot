<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\SolvedBlundersIdsResponse;
use App\Service\Message\SendMessageService;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Message;
use Doctrine\DBAL\Exception;

class SendSolvedBlunderIdsToUserCommand extends AbstractCommand
{
    const NAME = 'Send solved blunders command';

    private BlunderRepository $blunderRepository;

    public function __construct
    (
        Message $message,
    )
    {
        $this->blunderRepository = new BlunderRepository();
        parent::__construct($message);
    }

    public static function getCommandName(): string
    {
        return self::NAME;
    }

    /**
     * #solved [elo, id, moves] [asc, desc]
     *
     * @throws Exception
     */
    public function execute(): AbstractResponse
    {
        $commandArray = explode(' ', $this->message->content);

        $orderByColumn = $commandArray[1] ?? 'id';
        $orderDirection = $commandArray[2] ?? 'asc';

        $oderDirectionMap = [
            'asc',
            'desc'
        ];

        if (!in_array($orderDirection, $oderDirectionMap)) {
            $orderDirection = 'asc';
        }

        /** @var Blunder[] $solvedBlunders */
        $solvedBlunders =
            $this->blunderRepository->getSolvedBlundersForUser(
                $this->message->author->id,
                $orderByColumn,
                $orderDirection
            );

        $response = 'No solved blunders...';

        if (!empty($solvedBlunders)) {
            if ($orderByColumn === 'moves') {
                usort($solvedBlunders, [$this, 'sortSolvedBlunders']);
                if ($orderDirection === 'desc') {
                    $solvedBlunders = array_reverse($solvedBlunders);
                }
            }

            $response = 'Your solved blunders: ';

            foreach ($solvedBlunders as $blunder) {
                $blunderId = $orderByColumn === 'id'
                    ? '**' . $blunder->getId() . '**'
                    : $blunder->getId();

                $elo = $orderByColumn === 'elo'
                    ? '**' . $blunder->getElo() . '**'
                    : $blunder->getElo();

                $moves = $orderByColumn === 'moves'
                    ? '**' . $blunder->getNumberOfMoves() . '**'
                    : $blunder->getNumberOfMoves();

                $response.= $blunderId . ' (' . $elo . ', ' . $moves . '), ';
            }

            $response = rtrim($response, ',');
        }

        return new SolvedBlundersIdsResponse($this->message, $response);
    }

    /**
     * @throws NoPermissionsException
     */
    public function sendProperMessage(callable $callback): void
    {
        $content = $this->message->author->username . ' is checking his solved blunders';

        SendMessageService::sendTextMessage($content, null, $callback);
    }

    private function sortSolvedBlunders(Blunder $a, Blunder $b): int
    {
        if ($a->getNumberOfMoves() >= $b->getNumberOfMoves()) {
            return 1;
        }

        return -1;
    }
}