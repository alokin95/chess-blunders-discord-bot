<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Entity\Resign;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\SolvedBlundersIdsResponse;
use App\Service\Message\SendMessageService;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Message;
use Doctrine\DBAL\Exception;

class SendResignedBlunderIdsToUserCommand extends AbstractCommand
{
    const NAME = 'Send resigned blunders command';

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
     * #resigned [elo, id, moves] [asc, desc]
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

        /** @var Blunder[] $resignedBlundersForUser */
        $resignedBlundersForUser =
            $this->blunderRepository->getResignedBlundersForUser(
                $this->message->author->id,
                $orderByColumn,
                $orderDirection
            );

        $response = 'No resigned blunders!';

        if (!empty($resignedBlundersForUser)) {
            if ($orderByColumn === 'moves') {
                usort($resignedBlundersForUser, [$this, 'sortResignedBlunders']);
                if ($orderDirection === 'desc') {
                    $resignedBlundersForUser = array_reverse($resignedBlundersForUser);
                }
            }

            $response = 'Your resigned blunders: ';

            foreach ($resignedBlundersForUser as $resignedBlunder) {
                $blunderId = $orderByColumn === 'id'
                    ? '**' . $resignedBlunder->getId() . '**'
                    : $resignedBlunder->getId();

                $elo = $orderByColumn === 'elo'
                    ? '**' . $resignedBlunder->getElo() . '**'
                    : $resignedBlunder->getElo();

                $moves = $orderByColumn === 'moves'
                    ? '**' . $resignedBlunder->getNumberOfMoves() . '**'
                    : $resignedBlunder->getNumberOfMoves();

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
        $content = $this->message->author->username . ' is checking his resigned blunders';

        SendMessageService::sendTextMessage($content, null, $callback);
    }

    private function sortResignedBlunders(Blunder $a, Blunder $b): int
    {
        if ($a->getNumberOfMoves() >= $b->getNumberOfMoves()) {
            return 1;
        }

        return -1;
    }
}