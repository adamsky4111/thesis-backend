<?php

namespace App\Repository;

use App\Entity\Base\EntityInterface;


interface RepositoryInterface
{
    public function save(EntityInterface $entity, bool $flush = true): EntityInterface;
    public function remove(EntityInterface $entity, bool $flush = true): EntityInterface;
}
