<?php


namespace App\Security;


use App\Service\Command\AbstractCommand;

interface SecurityInterface
{
    public function denyAccessUnlessGranted(AbstractCommand $abstractCommand);
}