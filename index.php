<?php

include __DIR__.'/core/bootstrap.php';

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


//    $embed = $discord->factory(Embed::class, [
//        'title' => 'kitica'
//    ]);

//    $discord->factory(Channel::class, [
//        'id' =>  '782037360502243332'
//    ])->sendMessage('adasda', false, $embed);




});


$blunderCreationService = new \App\Service\Blunder\BlunderCreationService(new \App\Service\Blunder\RandomBlunderService());
$blunder = $blunderCreationService->createBlunder();
$embed = new \App\Service\CreateEmbedMessageService($blunder, $discord);
$embed = $embed->createEmbed();


$discord->factory(Channel::class, [
    'id' =>  '782037360502243332'
])->sendEmbed($embed)->done(function (Message $message){

});

$discord->run();
