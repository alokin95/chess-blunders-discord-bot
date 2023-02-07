<?php

namespace App\Repository;

use App\Entity\Blunder;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

class BlunderRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Blunder::class);
    }

    /**
     * @throws Exception
     */
    private function getIdsOfSolvedBlundersForUser(string $user): array
    {
        $sql = "SELECT b.id FROM Blunder b INNER JOIN Solved_Blunders sb ON b.id = sb.blunder_id WHERE sb.user_id = $user";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchFirstColumn();
    }

    /**
     * @throws Exception
     */
    private function getIdsOfResignedBlundersForUser(string $user): array
    {
        $sql = "SELECT b.id FROM Blunder b INNER JOIN resignations r ON b.id = r.blunder_id WHERE r.user = $user";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchFirstColumn();
    }

    public function getUnsolvedBlundersForUser
    (
        string $user,
        string $orderColumn = 'id',
        string $orderDirection = 'asc'
    ): array
    {
        $orderMap = [
            'id',
            'elo',
        ];

        if (!in_array($orderColumn, $orderMap)) {
            $orderColumn = 'id';
        }

        $idsOfSolvedBlunders = $this->getIdsOfSolvedBlundersForUser($user);
        $idsOfSolvedBlunders = array_merge($idsOfSolvedBlunders, $this->getIdsOfResignedBlundersForUser($user));

        $qb = $this
            ->createQueryBuilder('b')
            ->andWhere('b.id NOT IN (:unsolvedBlunders)')
            ->setParameter('unsolvedBlunders', $idsOfSolvedBlunders)
            ->orderBy('b.' . $orderColumn, $orderDirection)
        ;

        return $qb->getQuery()->execute();
    }
}