<?php

include __DIR__.'/core/bootstrap.php';

use App\Service\Blunder\Chessblundersorg\BlunderCreationService;
use App\Service\Blunder\Chessblundersorg\RandomBlunderService;
use App\Service\Embed\CreateBlunderEmbedMessageService;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

$discord = discordApp();


$blunderCreationService = new BlunderCreationService(new RandomBlunderService());
$blunder = $blunderCreationService->createBlunder();
$embed = new CreateBlunderEmbedMessageService($blunder, $discord);
$embed = $embed->createEmbed();


$discord->factory(Channel::class, [
    'id' =>  env('DISCORD_TEXT_CHANNEL_ID')
])->sendEmbed($embed)->done(function (Message $message){
    die();
});

$discord->run();