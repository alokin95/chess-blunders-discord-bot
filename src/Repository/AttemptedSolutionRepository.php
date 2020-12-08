<?php

namespace App\Repository;

use App\Entity\AttemptedSolution;

class AttemptedSolutionRepository extends AbstractRepository
{
    protected $entity = AttemptedSolution::class;

    public function getNumberOfTries($user, $blunder)
    {
        return count(entityManager()->getRepository($this->entity)->findBy(['user' => $user, 'blunder' => $blunder]));
    }
}