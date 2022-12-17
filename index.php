<?php

include __DIR__.'/core/bootstrap.php';

use App\Exception\ExceptionHandler;
use App\Response\CommandHelpResponse;
use App\Service\Command\HandleCommandService;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$discord = discordApp();


$discord->on('ready', function ($discord) {
	echo "Bot is ready!", PHP_EOL;

    $discord->on(Event::MESSAGE_CREATE, function (Message $message, $discord) {
        $exceptionHandler = new ExceptionHandler();
        if (str_starts_with($message->content, '#')) {
            try {
                $handleMessageService = new HandleCommandService($message);
                $handleMessageService->handle();
            } catch (Throwable $exception) {
                $exceptionHandler->handle($exception, $message->content);
               return new CommandHelpResponse($message);
            }
        }
    });

});

$discord->run();
