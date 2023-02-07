<?php

namespace App\Repository;

use App\Entity\APIBlunder;
use Doctrine\DBAL\Exception;

class APIBlunderRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(APIBlunder::class);
    }

    /**
     * @throws Exception
     */
    public function getRandomBlunder(): array
    {
        $numberOfBlunders = $this->countNumberOfBlunders();
        $randomBlunder = rand(1, $numberOfBlunders);

        $sql = "SELECT * FROM APIBlunder WHERE id = $randomBlunder LIMIT 1";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchAllAssociative();
    }

    private function countNumberOfBlunders(): ?int
    {
        $sql = "SELECT COUNT(id) FROM APIBlunder";

        $stmt = entityManager()->getConnection()->prepare($sql);

        $stmt = $stmt->executeQuery();
        return $stmt->fetchNumeric()[0];
    }
}