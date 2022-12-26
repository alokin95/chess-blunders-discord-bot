<?php

namespace App\Repository;

use App\Entity\APIBlunder;
use Doctrine\DBAL\Exception;

class APIBlunderRepository extends AbstractRepository
{
    protected string $entity = APIBlunder::class;

    /**
     * @throws Exception
     */
    public function getRandomBlunder(): array
    {
        $sql = "SELECT * FROM APIBlunder ORDER BY rand() LIMIT 1";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchAllAssociative();
    }
}