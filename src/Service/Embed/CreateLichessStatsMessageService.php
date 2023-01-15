<?php

namespace App\Service\Embed;

use App\Entity\LichessAccount;
use App\Repository\LichessAccountRepository;
use App\Request\LichessRequest;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;
use Discord\Parts\Embed\Footer;
use GuzzleHttp\Exception\GuzzleException;

class CreateLichessStatsMessageService extends AbstractEmbed
{
    private LichessRequest $lichessRequest;
    private LichessAccountRepository $lichessAccountRepository;
    private Message $message;

    public function __construct(Message $message)
    {
        $this->message                  = $message;
        $this->lichessAccountRepository = new LichessAccountRepository();
        $this->lichessRequest           = new LichessRequest();
        parent::__construct();
    }

    /**
     * @throws GuzzleException
     */
    public function createEmbed(): Embed
    {
        /** @var LichessAccount $lichessAccount */
        $lichessAccount = $this->lichessAccountRepository->findOneBy(['user' => $this->message->author->id]);

        $lichessStatistics = $this->lichessRequest->getStatsByUsername($lichessAccount->getLichessUsername());

        $embed  = new Embed($this->discord);

        if (!is_array($lichessStatistics)) {
            $embed->fill([
                'title' => "Error when fetching Lichess stats"
            ]);

            return $embed;
        }

        $embed->fill([
            'title'         => $this->message->author->username . ' Lichess profile',
            'fields'        => $this->createCustomFields($lichessStatistics),
            'description'   => '[Link to profile](' . $lichessStatistics['url'] . ')'
        ]);

        return $embed;
    }

    private function createCustomFields(array $lichessStats): array
    {
        $fields = [];

        $username  = new Field($this->discord);
        $username->fill([
            'name'  => "Username",
            'value' => $lichessStats['username']
        ]);

        $minutesPlaying = round($lichessStats['playTime']['total'] / 60 / 60);
        $timeSpentPlaying = new Field($this->discord);
        $timeSpentPlaying->fill([
            'name'  => "Time spent playing (hours)",
            'value' => $minutesPlaying
        ]);

        $dateOfAccountCreation = date('d F, Y', floor($lichessStats['createdAt'] / 1000));
        $accountCreateDate = new Field($this->discord);
        $accountCreateDate->fill([
            'name'  => "Account created",
            'value' => $dateOfAccountCreation
        ]);

        $fields[] = $username;
        $fields[] = $accountCreateDate;
        $fields[] = $timeSpentPlaying;

        return array_merge($fields, $this->addGameModesToFields($lichessStats));
    }

    private function addGameModesToFields(array $lichessStats): array
    {
        $performance = $lichessStats['perfs'];

        $gameModeMap = [
            'bullet',
            'blitz',
            'rapid',
            'classical',
            'correspondence',
            'puzzle'
        ];

        $fields = [];
        foreach ($gameModeMap as $gameMode) {
            $field = new Field($this->discord);

            $field->fill([
                'name'  => ucfirst($gameMode),
                'value' => "Games: " . $performance[$gameMode]['games'] . "\nRating: " . $performance[$gameMode]['rating']
            ]);

            $fields[] = $field;
        }

        return $fields;
    }
}