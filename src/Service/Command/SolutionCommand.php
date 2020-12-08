<?php


namespace App\Service\Command;


use App\Repository\SolutionRepository;

class SolutionCommand extends AbstractCommand
{
    private $solutionRepository;

    public function __construct($message)
    {
        $this->solutionRepository = new SolutionRepository();
        parent::__construct($message);
    }

    public function execute()
    {
        $commandArray = explode(" ", $this->message->content);

        $blunderId = $commandArray[1];
        
        $blunderSolution = [];
        for ($i = 2; $i < count($commandArray); $i++)
        {
            $blunderSolution[] = $commandArray[$i];
        }

        dd($blunderSolution);
    }
}