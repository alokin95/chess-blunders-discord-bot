<?php

include __DIR__.'/core/bootstrap.php';

use App\Exception\ExceptionHandler;
use App\Service\Blunder\Chessblundersorg\BlunderCreationService;
use App\Service\Blunder\Chessblundersorg\RandomBlunderService;
use App\Service\Embed\CreateBlunderEmbedMessageService;
use App\Service\Message\SendMessageService;
use Discord\Discord;

$discord = discordApp();

$exceptionHandler = new ExceptionHandler();

$blunderCreationService = new BlunderCreationService(new RandomBlunderService());
$blunder = $blunderCreationService->createBlunder();
$embed = new CreateBlunderEmbedMessageService($blunder, $discord);
$embed = $embed->createEmbed();

$discord->on('ready', function (Discord $discord) use ($embed) {
    echo "Bot is ready!", PHP_EOL;

    $channel = DiscordChannelFactory::getDefaultChannel();

    SendMessageService::sendEmbedMessage($channel, $embed, function () {
        die();
    });
});


$discord->run();