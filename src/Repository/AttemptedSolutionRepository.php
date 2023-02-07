<?php

namespace App\Repository;

use App\Entity\AttemptedSolution;

class AttemptedSolutionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(AttemptedSolution::class);
    }

    public function getNumberOfTries($user, $blunder)
    {
        return count(entityManager()->getRepository($this->entity)->findBy(['user' => $user, 'blunder' => $blunder]));
    }
}