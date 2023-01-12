<?php

use App\Exception\ExceptionHandler;
use App\Service\Blunder\BlunderCreationServiceFactory;
use App\Service\Blunder\Chessblundersorg\ChessBlundersBlunderCreationService;
use App\Service\Blunder\Chessblundersorg\ChessBlundersRandomGetBlunderService;
use App\Service\Blunder\Lichessorg\LichessBlunderCreationService;
use App\Service\Blunder\Lichessorg\LichessRandomGetBlunderService;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Embed\CreateBlunderEmbedMessageService;
use App\Service\Message\SendMessageService;
use Discord\Discord;

try {
    include __DIR__.'/core/bootstrap.php';

    $discord = discordApp();

    $blunderCreationService = new BlunderCreationServiceFactory(new LichessBlunderCreationService(new LichessRandomGetBlunderService()));
    $blunder = $blunderCreationService->createBlunder();

    $embed = new CreateBlunderEmbedMessageService($blunder);
    $embed = $embed->createEmbed();

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