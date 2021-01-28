<?php


namespace App\Security;


trait CheckPermissionsTrait
{
    public function denyAccessUnless(SecurityInterface $security)
    {
        $security->denyAccessUnlessGranted();
    }
}