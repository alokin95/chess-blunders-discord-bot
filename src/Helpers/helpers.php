<?php

function config(string $file, string $key)
{
    $path = dirname(__DIR__, 2);
    $configArray = include ($path . '/config/' . $file . '.php');

    return $configArray[$key];
}