<?php


namespace App\Response;


use Discord\Parts\Channel\Message;
use Exception;

class BlunderNotSolvedResponse extends AbstractResponse
{
    private string $submittedSolution;
    public function __construct
    (
        Message $message,
        string $submittedSolution
    )
    {
        $this->submittedSolution = $submittedSolution;
        parent::__construct($message);
    }

    /**
     * @throws Exception
     */
    protected function sendResponse()
    {
        $response = 'Whoops! The solution: ' . $this->submittedSolution . ' is not correct. Try again!';

        $this->message->author->sendMessage($response);
    }
}