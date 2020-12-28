<?php


namespace App\Service\Embed;


use App\Service\Statistic\UserStatisticService;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;

class CreateStatsBlunderMessageService extends AbstractEmbed
{
    private $statisticService;
    private $message;

    public function __construct($message)
    {
        $this->message          = $message;
        $this->statisticService = new UserStatisticService();
        parent::__construct();
    }

    public function createEmbed()
    {
        $userStatistics = $this->statisticService->getUserStatistics($this->message->author->id);

        $embed  = new Embed($this->discord);

        $embed->fill([
            'title'         => 'User stats',
            'fields'        => $this->createCustomFields($userStatistics)
        ]);

        return $embed;
    }

    private function createCustomFields($userStatistics)
    {
        $solvedBlunders         = new Field($this->discord);
        $resignedBlunders       = new Field($this->discord);
        $highestRatedSolved     = new Field($this->discord);
        $lowestRatedResigned    = new Field($this->discord);
        $averageNumberPerSolved = new Field($this->discord);
        $averageNumberPerResign = new Field($this->discord);

        $solvedBlunders->fill([
            'name'  => "Solved blunders",
            'value' => $userStatistics['solvedBlunders']
        ]);

        $resignedBlunders->fill([
            'name'  => "Resigned blunders",
            'value' => $userStatistics['resignedBlunders']
        ]);

        $highestRatedSolved->fill([
            'name'  => 'Highest rated solved blunder',
            'value' => $userStatistics['highestRatedSolved'][0][1]
        ]);

        $lowestRatedResigned->fill([
            'name'  => 'Lowest rated resigned blunder',
            'value' => $userStatistics['lowestRatedResigned'][0][1]
        ]);

        $averageNumberPerSolved->fill([
            'name'  => 'Average moves before solving',
            'value' => '' . $userStatistics['averageNumberPerSolved'],
        ]);

        $averageNumberPerResign->fill([
            'name'  => 'Average moves before resigning',
            'value' => '' . $userStatistics['averageNumberPerResign']
        ]);

        return [$solvedBlunders, $resignedBlunders, $highestRatedSolved, $lowestRatedResigned, $averageNumberPerSolved, $averageNumberPerResign];
    }
}