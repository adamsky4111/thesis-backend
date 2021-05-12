<?php

namespace App\Repository\Stream;

use App\Entity\Stream\Stream;
use App\Filter\FilterInterface;
use App\Repository\RepositoryInterface;

interface StreamRepositoryInterface extends RepositoryInterface
{
    public function searchByFilter(FilterInterface $filter): array;
    public function findActive(int $id): ?Stream;
}
