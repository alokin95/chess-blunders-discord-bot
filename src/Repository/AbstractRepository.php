<?php


namespace App\Repository;


abstract class AbstractRepository
{
    protected $entity;

    public function findOneBy(array $criteria, array $orderBy = null)
    {
        return entityManager()->getRepository($this->entity)->findOneBy($criteria, $orderBy);
    }

    public function find(int $id)
    {
        return entityManager()->getRepository($this->entity)->find($id);
    }

    public function all()
    {
        return entityManager()->getRepository($this->entity)->findBy([]);
    }

    public function findBy(array $criteria, array $orderBy = null)
    {
        return entityManager()->getRepository($this->entity)->findBy($criteria, $orderBy);
    }
}