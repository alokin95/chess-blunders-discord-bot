<?php

namespace App\Response;

use App\Service\Message\SendMessageService;
use Discord\Http\Exceptions\NoPermissionsException;

class LichessUsernameUpdatedResponse extends AbstractResponse
{
    /**
     * @throws NoPermissionsException
     */
    protected function sendResponse()
    {
        $lichessUsername = explode(" ", $this->message->content);
        $lichessUsername = $lichessUsername[1];

        SendMessageService::sendTextMessage(
            $this->message->author->username
            . ' registered a Lichess username: '
            . $lichessUsername,
            null,
            function() use ($lichessUsername) {
                $this->message->author->sendMessage(
                    "Successfully registered a Lichess username: $lichessUsername"
                );
            }
        );
    }
}