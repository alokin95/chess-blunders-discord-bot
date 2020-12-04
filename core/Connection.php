<?php

class Connection
{
    private static $instance = null;

    private function __construct()
    {
    }

    public static function getInstance($connection, $configuration)
    {
        if (self::$instance === null)
        {
            self::$instance =  Doctrine\ORM\EntityManager::create($connection, $configuration);;
        }

        return self::$instance;
    }
}