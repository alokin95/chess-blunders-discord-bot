<?php

use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;

include __DIR__.'/core/bootstrap.php';

$discord = discordApp();

$embed = new Embed($discord);

$customField = new Field($discord);

$customField->fill([
    'name'  => "#resign [blunderID]",
    'value' => "\nExample: #resign 13\n\nEnter this command to see the solution of the blunder. But be careful! Everyone else will know that you've given up, and you will no longer have the permission to send the solution for that blunder."
]);

$embed->fill([
    'title'         => 'Chess Blunders Bot received an update!',
    'description'   => '**New command available:**',
    'fields'        => [$customField]
]);

$discord->factory(Channel::class, [
    'id' =>  env('DISCORD_TEXT_CHANNEL_ID')
])->sendEmbed($embed)->done(function (Message $message){
    die();
});

$discord->run();
