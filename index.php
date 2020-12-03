<?php

include __DIR__.'/core/bootstrap.php';
dd(entityManager());
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;
$b = new \App\Service\Blunder\BlunderCreationService(new \App\Service\Blunder\RandomBlunderService());
$blunder = $b->createBlunder();
$embed = new \App\Service\CreateEmbedMessageService($blunder);
$embed->createEmbed();
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

//    $discord->factory(Channel::class, [
//        'id' =>  '782037360502243332'
//    ])->sendMessage('test');

});


//$discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
//    if (strpos($message->content, '#') === 0) {
//        echo 'JA SAM', PHP_EOL;
//    }
//});

$discord->run();
