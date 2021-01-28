<?php


namespace App\Security;


interface SecurityInterface
{
    public function denyAccessUnlessGranted();
}