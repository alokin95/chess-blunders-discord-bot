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
    'name'  => "Command improvements\n",
    'value' =>
        "
            - **#stats** command is now available in the global channel (per Yngvy's request).
            
            -**#solution** and **#resign** commands will no longer be available in the global channel, instead the user will have to send them directly to the Bot (per Yngvy's request).
            
            -User statistics now showing the average ELO of solved and resigned blunders.
            "
]);

$embed->fill([
    'title'         => 'Chess Blunders Bot received an update!',
    'description'   => '**Update notes:**',
    'fields'        => [$customField]
]);

$discord->factory(Channel::class, [
    'id' =>  env('DISCORD_TEXT_CHANNEL_ID')
])->sendEmbed($embed)->done(function (Message $message){
    die();
});

$discord->run();
