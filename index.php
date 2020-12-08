<?php

include __DIR__.'/core/bootstrap.php';

use App\Response\CommandHelpResponse;
use App\Service\Command\HandleCommandService;
use Discord\Discord;

$discord = new Discord([
	'token' => env('DISCORD_BOT_SECRET'),
]);

$discord->on('ready', function ($discord) {
	echo "Bot is ready!", PHP_EOL;

    $discord->on('message', function ($message, $discord) {
        if (strpos($message->content, '#') === 0) {
            try {
                $handleMessageService = new HandleCommandService($message);
                $handleMessageService->handle();
            } catch (Throwable $exception) {
               return new CommandHelpResponse($message);
            }
        }
    });

});

$discord->run();
