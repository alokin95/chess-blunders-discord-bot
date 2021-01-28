<?php


namespace App\Repository;


use App\Entity\Resign;

class ResignRepository extends AbstractRepository
{
    protected $entity = Resign::class;

    public function getResignsByUserAndBlunder($user, $blunder)
    {
        return $this->findOneBy(['user' => $user, 'blunder' => $blunder]);
    }

    public function countResignedBlunders($user)
    {
        return entityManager()->getRepository($this->entity)->count(['user' => $user]);
    }

    public function getLowestRatedResigned($user)
    {
        $qb = entityManager()->createQuery('SELECT MIN(b.elo) FROM App\Entity\Resign r JOIN r.blunder b WHERE r.user =' . $user);
        return $qb->getResult();
    }

    public function getAverageNumberOfAttempts($user)
    {
        $sql = "SELECT COUNT(as2.blunder_id ) as tries, as2.blunder_id FROM AttemptedSolutions as2 JOIN resignations r ON as2.blunder_id = r.blunder_id WHERE as2.user_id = $user GROUP BY as2.blunder_id ";
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

    public function getAverageEloOfResignedBlunders($user)
    {
        $qb = entityManager()->createQuery('SELECT AVG(b.elo) FROM App\Entity\Resign r JOIN r.blunder b WHERE r.user =' . $user);
        return $qb->getResult();
    }
}