<?php

include __DIR__.'/vendor/autoload.php';
include __DIR__.'/src/Helpers/helpers.php';

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\WebSockets\Event;

$discord = new Discord([
	'token' => 'NzgyMDI4NDcyNTkwNTMyNjU4.X8GOxQ.6BwFhLt1lciKmU4iB1Vv8prBf9E',
]);


$discord->on('ready', function ($discord) {
	echo "Bot is ready!", PHP_EOL;

	// Listen for messages.

    $discord->on('message', function ($message, $discord) {
        echo "{$message->author->username}: {$message->content}",PHP_EOL;
    });

//    $discord->factory(Channel::class, [
//        'id' =>  '782037360502243332'
//    ])->sendMessage('test');

});


$discord->on(Event::MESSAGE_CREATE, function (Message $message, Discord $discord) {
    if (strpos($message->content, '#') === 0) {
        echo 'JA SAM', PHP_EOL;
    }
});

$discord->run();
