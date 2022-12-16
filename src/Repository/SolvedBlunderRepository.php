<?php

namespace App\Repository;

use App\Entity\AttemptedSolution;
use App\Entity\SolvedBlunder;

class SolvedBlunderRepository extends AbstractRepository
{
    protected string $entity = SolvedBlunder::class;

    public function checkIfUserSolvedTheBlunder($blunder, string $user)
    {
        return $this->findOneBy(['blunder' => $blunder, 'user' => $user]);
    }

    public function countSolvedBlunders($user): int
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
        $sql = "SELECT  COUNT(sb.blunder_id) as tries, sb.blunder_id
                FROM Solved_Blunders sb 
	                JOIN AttemptedSolutions a123 ON a123.blunder_id = sb.blunder_id AND sb.user_id = a123.user_id 
                WHERE sb.user_id = $user
                GROUP BY sb.blunder_id";

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