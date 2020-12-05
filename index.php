<?php

include __DIR__.'/core/bootstrap.php';

use App\Service\Blunder\Chessblundersorg\BlunderCreationService;
use App\Service\Blunder\Chessblundersorg\RandomBlunderService;
use App\Service\CreateEmbedMessageService;
use Discord\Discord;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

$discord = new Discord([
	'token' => env('DISCORD_BOT_SECRET'),
]);

$discord->on('ready', function ($discord) {
	echo "Bot is ready!", PHP_EOL;

	// Listen for messages.

    $discord->on('message', function ($message, $discord) {
        if (strpos($message->content, '#') === 0) {
            $handleMessageService = new \App\Service\HandleIncomingMessageService($message);
            $handleMessageService->handle();
        }
    });

});

$discord->run();
