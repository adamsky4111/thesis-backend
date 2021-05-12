<?php

namespace App\Repository\Stream;

use App\Entity\Stream\Message;
use App\Repository\RepositoryInterface;

interface MessageRepositoryInterface extends RepositoryInterface
{
    public function findActive(int $id): ?Message;
}
