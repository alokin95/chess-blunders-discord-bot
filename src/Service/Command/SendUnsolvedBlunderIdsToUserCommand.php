<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\UnsolvedBlundersIdsResponse;
use App\Service\Message\SendMessageService;
use Discord\Parts\Channel\Message;

class SendUnsolvedBlunderIdsToUserCommand extends AbstractCommand implements ShouldBeSentPrivatelyInterface
{
    const NAME = 'Send unsolved blunders command';

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
     * #unsolved [elo, id, moves] [asc, desc]
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

        /** @var Blunder[] $unsolvedBlunders */
        $unsolvedBlunders =
            $this->blunderRepository->getUnsolvedBlundersForUser(
                $this->message->author->id,
                $orderByColumn,
                $orderDirection
            );

        $response = 'No unsolved blunders!';

        if (!empty($unsolvedBlunders)) {
            if ($orderByColumn === 'moves') {
                usort($unsolvedBlunders, [$this, 'sortUnsolvedBlunders']);
                if ($orderDirection === 'desc') {
                    $unsolvedBlunders = array_reverse($unsolvedBlunders);
                }
            }

            $response = 'Your unsolved blunders: ';

            foreach ($unsolvedBlunders as $blunder) {
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

        return new UnsolvedBlundersIdsResponse($this->message, $response);
    }

    public function sendProperMessage(callable $callback): void
    {
        $content = $this->message->author->username . ' is checking his unsolved blunders';

        SendMessageService::sendTextMessage($content, null, $callback);
    }

    private function sortUnsolvedBlunders(Blunder $a, Blunder $b): int
    {
        if ($a->getNumberOfMoves() >= $b->getNumberOfMoves()) {
            return 1;
        }

        return -1;
    }
}