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
        'name'  => "New and imrpoved commands\n",
        'value' =>
            "
            - **#blunder [blunderId]** command is now available! Send `#blunder blunderId` to receive blunder image to your private message from the Bot!
            
            - **#unsolved (`elo`, `id`)** command is now available! Send `#unsolved` message to receive ALL your unsolved blunder ids! Add `elo` or `id` flag for ordering (ex. #unsolved elo).
            
            -**#blunder** and **#unsolved** commands will not be available in the global channel, instead the user will have to send them directly to the Bot.
            
            -Bot is now deleting the messages that are not being sent to the private message (except `#stats` command).
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

