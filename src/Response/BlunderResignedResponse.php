<?php


namespace App\Response;


use App\Entity\Blunder;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

class BlunderResignedResponse extends AbstractResponse
{
    private Blunder $blunder;
    private ?Discord $discordApp;
    private array $solution;
    private int $attempts;

    public function __construct(Message $message, Blunder $blunder, array $solution, int $attempts)
    {
        $this->blunder      = $blunder;
        $this->discordApp   = discordApp();
        $this->solution     = $solution;
        $this->attempts     = $attempts;
        parent::__construct($message);
    }

    protected function sendResponse()
    {
        $attempts = "";

        if ($this->attempts == 0) {
            $attempts = "without trying to solve it!";
        }
        elseif ($this->attempts == 1) {
            $attempts = "after trying to solve it only one time!";
        }
        else $attempts = "after $this->attempts tries.";

        $message = $this->message->author->username . ' has resigned the blunder ' . $this->blunder->getId() . ' ' . $attempts;

        $this->discordApp->factory(Channel::class, [
            'id' => env('DISCORD_TEXT_CHANNEL_ID')
        ])->sendMessage($message);

        $solution = $this->formatSolution();

        $this->message->author->sendMessage('The solution for blunder ' . $this->blunder->getId() . ' is ' . $solution . '.');
    }

    private function formatSolution(): string
    {
        return implode(" ", $this->solution);
    }
}