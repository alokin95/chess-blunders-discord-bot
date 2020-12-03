<?php
// bootstrap.php
require_once "vendor/autoload.php";
include __DIR__ . '/helpers.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array("src/Entity");
$isDevMode = false;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => env('DATABASE_USERNAME'),
    'password' => env('DATABASE_PASSWORD'),
    'dbname'   => env('DATABASE_NAME'),
);

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);