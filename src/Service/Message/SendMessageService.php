<?php

namespace App\Service\Message;

use Discord\Builders\MessageBuilder;
use Discord\Parts\Channel\Channel;
use Discord\Parts\Channel\Message;
use Discord\Parts\Embed\Embed;

class SendMessageService
{
    public static function sendTextMessage(
        Channel $channel,
        string $content,
        ?Embed $embed = null,
        ?bool $isTextToSpeech = false,
        callable $callback = null
    ): void
    {
        $message = MessageBuilder::new()
            ->setContent($content)
            ->setTts($isTextToSpeech);

        if (!is_null($embed)) {
            $message->setContent($content);
        }

        $channel->sendMessage($message)->done(function (Message $message) use ($callback) {
            if (!is_null($callback)) {
                $callback();
            }
        });
    }

    public static function sendEmbedMessage(
        Channel $channel,
        Embed $embed,
        callable $callback = null
    ): void
    {
        $channel->sendEmbed($embed)->done(function (Message $message) use ($callback) {
            if (!is_null($callback)) {
                $callback();
            }
        });
    }
}