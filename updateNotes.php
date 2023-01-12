<?php

use App\Exception\ExceptionHandler;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Message\SendMessageService;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;

try {
    include __DIR__.'/core/bootstrap.php';

    $discord = discordApp();

    $embed = new Embed($discord);

    $customField = new Field($discord);
    $customField1 = new Field($discord);

    $customField->fill([
        'name'  => "**Lichess integration is here!**\n",
        'value' =>
            "
            - We are now receiving the daily puzzles from the Lichess.org. Good luck!
            "
    ]);

    $customField1->fill([
        'name'  => "**Improvements:**\n",
        'value' =>
            "
            - Chess board now shows what is the last move that was being played before the blunder solution.
            "
    ]);

    $embed->fill([
        'title'         => 'Chess Blunders Bot received an update!',
        'description'   => '**Update notes:**',
        'fields'        => [$customField, $customField1]
    ]);

    $discord->on('ready', function (Discord $discord) use ($embed) {
        echo "Bot is ready!", PHP_EOL;

        $channel = DiscordChannelFactory::getDefaultChannel();

        SendMessageService::sendEmbedMessage($embed, $channel, function () {
            die();
        });
    });


    $discord->run();
} catch (Throwable $throwable) {
    $exceptionHandler = new ExceptionHandler();
    $exceptionHandler->handle($throwable, basename(__FILE__, '.php'));
}

