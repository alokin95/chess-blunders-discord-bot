<?php

use Discord\Exceptions\IntentException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

include 'Connection.php';
include 'DiscordConnection.php';

function config(string $file, string $key)
{
    $path = dirname(__DIR__, 1);
    $configArray = include ($path . '/config/' . $file . '.php');

    if (array_key_exists($key, $configArray)) {
        return $configArray[$key];
    }

    return false;
}

function env($key): ?string
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

function entityManager(): ?EntityManager
{
    $configuration = ORMSetup::createAttributeMetadataConfiguration(
        paths: config('doctrine', 'paths'),
        isDevMode: config('doctrine', 'isDevMode'),
    );
    
    $connection_parameters = config('doctrine', 'connection');

    return Connection::getInstance($connection_parameters, $configuration);
}

/**
 * @throws IntentException
 */
function discordApp(): ?\Discord\Discord
{
    return DiscordConnection::getInstance();
}