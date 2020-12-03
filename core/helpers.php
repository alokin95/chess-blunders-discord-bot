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

function entityManager()
{
    $configuration = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        config('doctrine', 'paths'),
        config('doctrine', 'isDevMode'),
        config('doctrine', 'proxyDir'),
        config('doctrine', 'cache'),
        config('doctrine', 'useSimpleAnnotationReader')
    );
    
    $connection_parameters = config('doctrine', 'connection');

    $entity_manager = Doctrine\ORM\EntityManager::create($connection_parameters, $configuration);

    return $entity_manager;
}