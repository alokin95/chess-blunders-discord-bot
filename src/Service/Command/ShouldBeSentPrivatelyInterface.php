<?php

namespace App\Service\Command;

interface ShouldBeSentPrivatelyInterface
{
    public function sendProperMessage(callable $callback): void;
}