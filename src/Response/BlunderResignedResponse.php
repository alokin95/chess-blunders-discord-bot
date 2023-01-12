<?php


namespace App\Response;


use App\Entity\Blunder;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Message\SendMessageService;
use Discord\Discord;
use Discord\Http\Exceptions\NoPermissionsException;
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

    /**
     * @throws NoPermissionsException
     */
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

        SendMessageService::sendTextMessage($message);

        $solution = $this->formatSolution();

        $this->message->author->sendMessage('The solution for blunder ' . $this->blunder->getId() . ' is ' . $solution . '.');
    }

    private function formatSolution(): string
    {
        return implode(" ", $this->solution);
    }
}