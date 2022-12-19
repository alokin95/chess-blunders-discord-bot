<?php

namespace App\Repository;

use App\Entity\AttemptedSolution;

class AttemptedSolutionRepository extends AbstractRepository
{
    protected string $entity = AttemptedSolution::class;

    public function getNumberOfTries($user, $blunder)
    {
        return count(entityManager()->getRepository($this->entity)->findBy(['user' => $user, 'blunder' => $blunder]));
    }

    public function findByAttemptedSolution(array $submittedSolution)
    {
        $sql = 'SELECT * FROM AttemptedSolutions as2 WHERE as2.submitted_solution LIKE %' . serialize($submittedSolution) . '%';

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchOne();
    }
}