<?php

namespace App\Repository;

use App\Entity\SolvedBlunder;

class SolvedBlunderRepository extends AbstractRepository
{
    protected $entity = SolvedBlunder::class;

    public function checkIfUserSolvedTheBlunder($blunder, string $user)
    {
        return $this->findOneBy(['blunder' => $blunder, 'user' => $user]);
    }
}