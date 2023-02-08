<?php

use App\Exception\ExceptionHandler;
use App\Service\Channel\DiscordChannelFactory;
use App\Service\Message\SendMessageService;
use Discord\Discord;
use Discord\Parts\Embed\Embed;
use Discord\Parts\Embed\Field;

try {
    include __DIR__.'/core/bootstrap.php';

    $discord = discordApp();

    $embed = new Embed($discord);

    $mainChangesField = new Field($discord);
    $improvementsField = new Field($discord);
    $newCommandsField = new Field($discord);

    $mainChangesField->fill([
        'name'  => "**RANKINGS ARE HERE!**\n",
        'value' =>
            "
            -   We are now rating the players by their performance! 
                Every player will see his rating deviate based on the submitted solution.
                Be aware that the more moves you take, the less point you gain than your adversaries!
                And did we forget to mention that every time you resign, you will lose ratings?
                Be careful and good luck!
            "
    ]);

    $newCommandsField->fill([
        'name'  => "**New and improved commands:**\n",
        'value' =>
            "
            - **#solution** command has been renamed to **#solve**! Use **#solve** command to send your awesome solutions!
            - **#solved** - Now you can see all your already solved commands! See **#help** for sorting options
            - **#resigned** - Now you can see all your resigned commands! See **#help** for sorting options
            "
    ]);

    $improvementsField->fill([
        'name'  => "**Quality of live improvements:**\n",
        'value' =>
            "
            - **#solve** command now returns an error when a user submits a wrong number of moves.
            - **#unsolved** command now sortable by number of moves by typing `#unsolved moves`. You can also choose the 
                sorting direction with `asc` or `desc`. Example: `#unsolved moves asc`
            - #stats command now shows the user's title, rating, number of unsolved blunders and the average elo of unsolved blunders
            "
    ]);

    $embed->fill([
        'title'         => 'Chess Blunders Bot received an update!',
        'description'   => '**Update notes:**',
        'fields'        => [$mainChangesField, $newCommandsField, $improvementsField]
    ]);

    $discord->on('ready', function (Discord $discord) use ($embed) {
        echo "Bot is ready!", PHP_EOL;

        $channel = DiscordChannelFactory::getDefaultChannel();

        SendMessageService::sendEmbedMessage($embed, $channel, function () {
            die();
        });
    });


    $discord->run();
} catch (Throwable $throwable) {
    $exceptionHandler = new ExceptionHandler();
    $exceptionHandler->handle($throwable, basename(__FILE__, '.php'));
}

