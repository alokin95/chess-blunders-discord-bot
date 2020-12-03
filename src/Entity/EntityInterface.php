<?php

namespace App\Entity;

use DateTime;

interface EntityInterface
{
    public function getCreatedAt();

    public function setCreatedAt(DateTime $createdAt);

    public function getUpdatedAt();

    public function setUpdatedAt(DateTime $updatedAt);

    public function updateTimestamps();
}