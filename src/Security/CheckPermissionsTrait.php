<?php


namespace App\Security;


use App\Service\Command\AbstractCommand;

trait CheckPermissionsTrait
{
    public function denyAccessUnless(SecurityInterface $security, AbstractCommand $command): void
    {
        $security->denyAccessUnlessGranted($command);
    }
}