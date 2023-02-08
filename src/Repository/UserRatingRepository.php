<?php

namespace App\Repository;

use App\Entity\UserRating;

class UserRatingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(UserRating::class);
    }
}