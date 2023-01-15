<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[Entity]
#[HasLifecycleCallbacks]
class LichessAccount extends BaseEntity
{
    #[Column(type: 'string', nullable: false)]
    private ?string $user = null;

    #[Column(type: 'string', nullable: false)]
    private ?string $lichessUsername = null;

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): void
    {
        $this->user = $user;
    }

    public function getLichessUsername(): ?string
    {
        return $this->lichessUsername;
    }

    public function setLichessUsername(?string $lichessUsername): void
    {
        $this->lichessUsername = $lichessUsername;
    }
}