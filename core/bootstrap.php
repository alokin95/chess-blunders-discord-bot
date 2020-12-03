<?php
require_once "vendor/autoload.php";
require_once "helpers.php";
// Setup Doctrine
$configuration = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $paths = [__DIR__ . '/../src/Entity'],
    $isDevMode = true,
    true,
    null,
    false
);

// Setup connection parameters
$connection_parameters = [
    'dbname' => env('DATABASE_NAME'),
    'user' => env('DATABASE_USERNAME'),
    'password' => env('DATABASE_PASSWORD'),
    'host' => env('DATABASE_HOST'),
    'driver' => 'pdo_mysql'
];

// Get the entity manager
$entity_manager = Doctrine\ORM\EntityManager::create($connection_parameters, $configuration);