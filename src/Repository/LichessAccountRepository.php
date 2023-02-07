<?php

namespace App\Repository;

use App\Entity\LichessAccount;

class LichessAccountRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(LichessAccount::class);
    }
}