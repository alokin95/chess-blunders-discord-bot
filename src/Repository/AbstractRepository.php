<?php


namespace App\Repository;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

abstract class AbstractRepository extends EntityRepository
{
    public function __construct(string $classPath)
    {
        parent::__construct(entityManager(), entityManager()->getClassMetadata($classPath));
    }
}