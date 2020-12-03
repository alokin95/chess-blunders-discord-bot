<?php

return [

    'paths'                     => [__DIR__ . '/../src/Entity'],
    'isDevMode'                 => true,
    'proxyDir'                  => true,
    'cache'                     => null,
    'useSimpleAnnotationReader' => false,

    'connection' => [
        'dbname' => env('DATABASE_NAME'),
        'user' => env('DATABASE_USERNAME'),
        'password' => env('DATABASE_PASSWORD'),
        'host' => env('DATABASE_HOST'),
        'driver' => 'pdo_mysql'
    ]
];