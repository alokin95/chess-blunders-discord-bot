<?php

namespace App\Service\Command;

use App\Repository\LichessAccountRepository;
use App\Response\AbstractResponse;
use App\Response\NeedToRegisterLichessUsernameResponse;
use App\Service\Embed\CreateLichessStatsMessageService;
use Discord\Exceptions\IntentException;
use Discord\Parts\Channel\Message;
use App\Response\UserStatisticResponse;
use GuzzleHttp\Exception\GuzzleException;

class LichessStatsCommand extends AbstractCommand
{
    private LichessAccountRepository $lichessAccountRepository;
    private CreateLichessStatsMessageService $lichessStatsMessageService;
    public function __construct
    (
        Message $message
    )
    {
        $this->lichessStatsMessageService = new CreateLichessStatsMessageService($message);
        $this->lichessAccountRepository = new LichessAccountRepository();
        parent::__construct($message);
    }
    public static function getCommandName(): string
    {
        return 'Lichess stats';
    }

    /**
     * #lichessStats
     *
     * @throws IntentException|GuzzleException
     */
    public function execute(): AbstractResponse
    {
        $user = $this->message->author->id;

        if (!$this->lichessAccountRepository->findOneBy(['user' => $user])) {
            return new NeedToRegisterLichessUsernameResponse($this->message);
        }

        $embed = $this->lichessStatsMessageService->createEmbed();

        return new UserStatisticResponse($this->message, $embed);
    }
}