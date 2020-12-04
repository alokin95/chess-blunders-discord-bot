<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

interface EntityInterface
{
    public function getCreatedAt();

    public function setCreatedAt(DateTime $createdAt);

    public function getUpdatedAt();

    public function setUpdatedAt(DateTime $updatedAt);

    /**
     * @ORM\PreUpdate()
     * @ORM\PrePersist()
     */
    public function updateTimestamps();
}