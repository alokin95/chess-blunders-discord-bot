<?php

namespace App\Repository;

use App\Entity\Blunder;
use Doctrine\DBAL\Exception;

class BlunderRepository extends AbstractRepository
{
    protected string $entity = Blunder::class;

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

    public function getUnsolvedBlundersForUser(string $user, string $orderByColumn = 'id'): array
    {
        $idsOfSolvedBlunders = $this->getIdsOfSolvedBlundersForUser($user);
        $idsOfSolvedBlunders = array_merge($idsOfSolvedBlunders, $this->getIdsOfResignedBlundersForUser($user));

        $idsOfSolvedBlunders = implode(',', $idsOfSolvedBlunders);
        $sql = "SELECT * FROM Blunder b WHERE b.id NOT IN ($idsOfSolvedBlunders) ORDER BY $orderByColumn";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchAllAssociative();
    }
}