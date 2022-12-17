<?php

include __DIR__.'/core/bootstrap.php';

use App\Exception\ExceptionHandler;
use App\Service\Blunder\Chessblundersorg\BlunderCreationService;
use App\Service\Blunder\Chessblundersorg\RandomBlunderService;
use App\Service\Embed\CreateBlunderEmbedMessageService;
use App\Service\Message\SendMessageService;
use Discord\Helpers\Collection;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;

$discord = discordApp();

$exceptionHandler = new ExceptionHandler();

$blunderCreationService = new BlunderCreationService(new RandomBlunderService());
$blunder = $blunderCreationService->createBlunder();
$embed = new CreateBlunderEmbedMessageService($blunder, $discord);
$embed = $embed->createEmbed();


$channel = new Channel($discord);

$channel->fill([
    'id' => env('DISCORD_TEXT_CHANNEL_ID')
]);

$channel->getPinnedMessages()->done(function (Collection $messages) {

});

$channel->sendMessage('asdasd')->done(function (Message $message)  {

});

dd($channel->id);
//$channel->id = env('DISCORD_TEXT_CHANNEL_ID');

//try {
    SendMessageService::sendTextMessage($channel, 'sdadas', null, false, function () {
        die('here');
    });

//    $discord->factory(Channel::class, [
//    'id' =>  env('DISCORD_TEXT_CHANNEL_ID')
//])->sendEmbed($embed)->done(function (Message $message){
//    die();
//});

//} catch (Throwable $exception) {
//    $exceptionHandler->handle($exception, __FILE__);
//    die();
//}

$discord->run();