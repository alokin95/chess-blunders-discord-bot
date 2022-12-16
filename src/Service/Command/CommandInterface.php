<?php

namespace App\Service\Command;

use App\Response\AbstractResponse;

interface CommandInterface
{
    public function execute(): AbstractResponse;
}