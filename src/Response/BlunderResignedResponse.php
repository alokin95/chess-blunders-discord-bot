<?php


namespace App\Response;


use Discord\Parts\Channel\Channel;

class BlunderResignedResponse extends AbstractResponse
{
    private $blunder;
    private $discordApp;
    private $solution;

    public function __construct($message, $blunder, $solution)
    {
        $this->blunder      = $blunder;
        $this->discordApp   = discordApp();
        $this->solution     = $solution;
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $message = $this->message->author->username . ' has resigned the blunder ' . $this->blunder->getId();

        $this->discordApp->factory(Channel::class, [
            'id' => env('DISCORD_TEXT_CHANNEL_ID')
        ])->sendMessage($message);

        $solution = $this->formatSolution();

        $this->message->author->sendMessage('The solution for blunder ' . $this->blunder->getId() . ' is ' . $solution);
    }

    private function formatSolution()
    {
        return implode(" ", $this->solution);
    }
}