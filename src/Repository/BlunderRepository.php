<?php

namespace App\Repository;

use App\Entity\Blunder;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
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

    /**
     * @throws Exception
     */
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
            ->orderBy('b.' . $orderColumn, $orderDirection)
        ;

        if (!empty($idsOfSolvedBlunders)) {
            $qb
                ->andWhere('b.id NOT IN (:solvedBlunders)')
                ->setParameter('solvedBlunders', $idsOfSolvedBlunders);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @throws Exception
     */
    public function getSolvedBlundersForUser
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

        $qb = $this
            ->createQueryBuilder('b')
            ->orderBy('b.' . $orderColumn, $orderDirection)
        ;

        if (!empty($idsOfSolvedBlunders)) {
            $qb
                ->andWhere('b.id IN (:solvedBlunders)')
                ->setParameter('solvedBlunders', $idsOfSolvedBlunders);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @throws Exception
     */
    public function getResignedBlundersForUser
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

        $idsOfResignedBlunders = $this->getIdsOfResignedBlundersForUser($user);

        $qb = $this
            ->createQueryBuilder('b')
            ->orderBy('b.' . $orderColumn, $orderDirection)
        ;

        if (!empty($idsOfResignedBlunders))  {
            $qb
                ->andWhere('b.id IN (:resignedBlunders)')
                ->setParameter('resignedBlunders', $idsOfResignedBlunders);
        }

        return $qb->getQuery()->execute();
    }

    /**
     * @throws Exception
     */
    public function countUnsolvedBlunders($user): int
    {
        return count($this->getUnsolvedBlundersForUser($user));
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     * @throws Exception
     */
    public function getAverageEloOfUnsolvedBlunders($user)
    {
        $idsOfSolvedBlunders = $this->getIdsOfSolvedBlundersForUser($user);
        $idsOfSolvedBlunders = array_merge($idsOfSolvedBlunders, $this->getIdsOfResignedBlundersForUser($user));

        return $this->createQueryBuilder('b')
            ->select('avg(b.elo)')
            ->andWhere('b.id NOT IN (:idsOfSolvedBlunders)')
            ->setParameter('idsOfSolvedBlunders', $idsOfSolvedBlunders)

            ->getQuery()->getSingleScalarResult()
        ;

    }
}