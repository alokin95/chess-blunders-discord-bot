<?php
require_once "vendor/autoload.php";
require_once "helpers.php";
// Setup Doctrine
$configuration = Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    config('doctrine', 'paths'),
    config('doctrine', 'isDevMode'),
    config('doctrine', 'proxyDir'),
    config('doctrine', 'cache'),
    config('doctrine', 'useSimpleAnnotationReader')
);

// Setup connection parameters
$connection_parameters = config('doctrine', 'connection');

// Get the entity manager
$entity_manager = entityManager();