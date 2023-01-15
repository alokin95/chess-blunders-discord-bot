<?php

namespace App\Service\Message;

use App\Service\Channel\DiscordChannelFactory;
use Discord\Builders\MessageBuilder;
use Discord\Http\Exceptions\NoPermissionsException;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class SendMessageService
{
    /**
     * @throws NoPermissionsException
     */
    public static function sendTextMessage(
        string $content,
        ?Channel $channel = null,
        callable $callback = null
    ): void
    {
        if (is_null($channel)) {
            $channel = DiscordChannelFactory::getDefaultChannel();
        }

        $message = MessageBuilder::new()
            ->setContent($content)
        ;

        $channel->sendMessage($message)->done(function (Message $message) use ($callback) {
            if (!is_null($callback)) {
                $callback();
            }
        });
    }

    public static function sendEmbedMessage(
        Embed $embed,
        ?Channel $channel = null,
        callable $callback = null
    ): void
    {
        if (is_null($channel)) {
            $channel = DiscordChannelFactory::getDefaultChannel();
        }

        $channel->sendEmbed($embed)->done(function (Message $message) use ($callback) {
            if (!is_null($callback)) {
                $callback();
            }
        });
    }

    public static function replyToMessage
    (
        Message $messageToReplyTo,
        string $content,
        ?Embed $embed = null,
        callable $callback = null
    ): void
    {
        $messageToReplyTo->author->getPrivateChannel()->then(function (Channel $channel)
            use ($embed, $content, $messageToReplyTo, $callback) {
                if (!is_null($embed)) {
                    self::sendEmbedMessage($embed, $channel);
                    $callback();
                    return;
                }

                self::sendTextMessage($content, $channel, $callback);

                $messageToReplyTo->delete();
        });
    }

    public static function sendMessageWithFile(
        string $content,
        string $filePath,
        string $fileName,
        ?Channel $channel = null,
        ?Embed $embed = null,
        callable $callback = null
    ): void
    {
        if (is_null($channel)) {
            $channel = DiscordChannelFactory::getDefaultChannel();
        }

        // /home/nikola/discordbot/assets/img/needMoreBlunder.jpg

        $messagebuilder = MessageBuilder::new()
            ->setContent($content)
            ->addFile($filePath, $fileName);
        $channel->sendMessage($messagebuilder);
    }
}