<?php

namespace App\Repository\Stream;

use App\Entity\Stream\Stream;

interface StreamRepositoryInterface
{
    public function save(Stream $stream, bool $flush = true): Stream;
}
