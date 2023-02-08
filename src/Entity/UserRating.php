<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[Entity]
#[HasLifecycleCallbacks]
class UserRating extends BaseEntity
{
    #[Column(type: "string", nullable: false)]
    private ?string $user = null;

    #[Column(type: "integer", nullable: false)]
    private ?int $rating = 1200;

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): void
    {
        $this->rating = $rating;
    }
}