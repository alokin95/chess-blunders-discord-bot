<?php

namespace App\Service\Command;

use App\Entity\Blunder;
use App\Repository\BlunderRepository;
use App\Response\AbstractResponse;
use App\Response\UnsolvedBlundersIdsResponse;
use Discord\Parts\Channel\Message;

class SendUnsolvedBlunderIdsToUserCommand extends AbstractCommand
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

    public function execute(): AbstractResponse
    {
        $commandArray = explode(' ', $this->message->content);

        $orderByColumn = $commandArray[1] ?? 'id';

        $orderMap = [
            'id',
            'elo'
        ];

        if (!in_array($orderByColumn, $orderMap)) {
            $orderByColumn = 'elo';
        }

        /** @var Blunder[] $unsolvedBlunders */
        $unsolvedBlunders = $this->blunderRepository->getUnsolvedBlundersForUser($this->message->author->id, $orderByColumn);

        $response = 'Your unsolved blunders: ';

        foreach ($unsolvedBlunders as $blunder) {
            $response.= $blunder['id'] . ' (' . $blunder['elo'] . '), ';
        }

        $response = rtrim($response, ',');

        return new UnsolvedBlundersIdsResponse($this->message, $response);
    }
}