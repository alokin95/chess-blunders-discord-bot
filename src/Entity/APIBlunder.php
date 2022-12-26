<?php

namespace App\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\HasLifecycleCallbacks;

#[Entity]
#[HasLifecycleCallbacks]
class APIBlunder extends BaseEntity
{
    #[Column(type: 'json')]
    private array $data = [];

    public function getJson(): array
    {
        return $this->data;
    }

    public function setJson(array $data): void
    {
        $this->data = $data;
    }
}