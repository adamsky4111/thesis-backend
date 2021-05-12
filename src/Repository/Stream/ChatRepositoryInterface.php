<?php

namespace App\Repository\Stream;

use App\Entity\Stream\Chat;
use App\Repository\RepositoryInterface;

interface ChatRepositoryInterface extends RepositoryInterface
{
    public function findActive(int $id) : Chat|null;
}
