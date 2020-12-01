<?php

function config(string $file, string $key)
{
    $path = dirname(__DIR__, 1);
    $configArray = include ($path . '/config/' . $file . '.php');

    return $configArray[$key];
}

function env($key)
{
    $path = dirname(__DIR__, 1);
    $file = file($path . '/.env');

    foreach ($file as $row) {
        $array = explode('=', $row);

        if ($key == $array[0]) {
            return trim($array[1]);
        }
    }

    return null;
}