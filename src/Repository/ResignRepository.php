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

}