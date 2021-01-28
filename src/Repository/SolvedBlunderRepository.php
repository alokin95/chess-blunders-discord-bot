<?php

namespace App\Repository;

use App\Entity\AttemptedSolution;
use App\Entity\SolvedBlunder;

class SolvedBlunderRepository extends AbstractRepository
{
    protected $entity = SolvedBlunder::class;

    public function checkIfUserSolvedTheBlunder($blunder, string $user)
    {
        return $this->findOneBy(['blunder' => $blunder, 'user' => $user]);
    }

    public function countSolvedBlunders($user)
    {
        return entityManager()->getRepository($this->entity)->count(['user' => $user]);
    }

    public function getHighestRated($user)
    {
        $qb = entityManager()->createQuery('SELECT MAX(b.elo) FROM App\Entity\SolvedBlunder sb JOIN sb.blunder b WHERE sb.user =' . $user);
        return $qb->getResult();
    }

    public function getLowestRated($user)
    {
        $qb = entityManager()->createQuery('SELECT MIN(b.elo) FROM App\Entity\SolvedBlunder sb JOIN sb.blunder b WHERE sb.user =' . $user);
        return $qb->getResult();
    }

    public function getAverageNumberOfAttempts($user)
    {
        $sql = "SELECT COUNT(as2.blunder_id ) as tries, as2.blunder_id FROM AttemptedSolutions as2 JOIN Solved_Blunders sb ON as2.blunder_id = sb.blunder_id WHERE as2.user_id = $user GROUP BY as2.blunder_id ";
        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt->execute();
        $result = $stmt->fetchAll();

        $numberOfTries = array_sum(array_map(function($item){
            return $item['tries'];
        }, $result));

        if (count($result) == 0)
        {
            return count($result);
        }

        return $numberOfTries / count($result);
    }

    public function getAverageEloOfSolvedBlunders($user)
    {
        $qb = entityManager()->createQuery('SELECT AVG(b.elo) FROM App\Entity\SolvedBlunder sb JOIN sb.blunder b WHERE sb.user =' . $user);
        return $qb->getResult();
    }
}