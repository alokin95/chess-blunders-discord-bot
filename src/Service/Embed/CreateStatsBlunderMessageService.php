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
            'title'         => $this->message->author->username . ' stats',
            'fields'        => $this->createCustomFields($userStatistics)
        ]);

        return $embed;
    }

    private function createCustomFields($userStatistics)
    {
        $solvedBlunders             = new Field($this->discord);
        $resignedBlunders           = new Field($this->discord);
        $highestRatedSolved         = new Field($this->discord);
        $lowestRatedResigned        = new Field($this->discord);
        $averageNumberPerSolved     = new Field($this->discord);
        $averageNumberPerResign     = new Field($this->discord);
        $averageEloOfSolvedBlunders = new Field($this->discord);
        $averageEloOfResignedBlunders = new Field($this->discord);

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
            'value' => $userStatistics['highestRatedSolved'][0][1] ?? 0
        ]);

        $lowestRatedResigned->fill([
            'name'  => 'Lowest rated resigned blunder',
            'value' => $userStatistics['lowestRatedResigned'][0][1] ?? 0
        ]);

        $averageNumberPerSolved->fill([
            'name'  => 'Average moves before solving',
            'value' => '' . round($userStatistics['averageNumberPerSolved'], 2),
        ]);

        $averageNumberPerResign->fill([
            'name'  => 'Average moves before resigning',
            'value' => '' . round($userStatistics['averageNumberPerResign'], 2)
        ]);

        $averageEloOfSolvedBlunders->fill([
            'name'  => 'Average ELO of solved blunders',
            'value' => '' . round($userStatistics['averageEloOfSolvedBlunders'][0][1], 0)
        ]);

        $averageEloOfResignedBlunders->fill([
            'name'  => 'Average ELO of resigned blunders',
            'value' => round($userStatistics['averageEloOfResignedBlunders'][0][1], 0)
        ]);

        return [
            $solvedBlunders,
            $resignedBlunders,
            $highestRatedSolved,
            $lowestRatedResigned,
            $averageNumberPerSolved,
            $averageNumberPerResign,
            $averageEloOfSolvedBlunders,
            $averageEloOfResignedBlunders];
    }
}