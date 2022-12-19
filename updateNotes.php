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

    $customField->fill([
        'name'  => "Command improvements\n",
        'value' =>
            "
            - **#stats** command is now available in the global channel (per Yngvy's request).
            
            -**#solution** and **#resign** commands will no longer be available in the global channel, instead the user will have to send them directly to the Bot (per Yngvy's request).
            
            -User statistics now showing the average ELO of solved and resigned blunders.
            "
    ]);

    $embed->fill([
        'title'         => 'Chess Blunders Bot received an update!',
        'description'   => '**Update notes:**',
        'fields'        => [$customField]
    ]);

    $discord->on('ready', function (Discord $discord) use ($embed) {
        echo "Bot is ready!", PHP_EOL;

        $channel = DiscordChannelFactory::getDefaultChannel();

        SendMessageService::sendEmbedMessage($channel, $embed, function () {
            die();
        });
    });


    $discord->run();
} catch (Throwable $throwable) {
    $exceptionHandler = new ExceptionHandler();
    $exceptionHandler->handle($throwable, basename(__FILE__, '.php'));
}

