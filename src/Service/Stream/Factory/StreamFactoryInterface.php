<?php

namespace App\Service\Stream\Factory;

use App\Dto\StreamDto;
use App\Entity\Stream\Channel;
use App\Entity\Stream\Stream;

interface StreamFactoryInterface
{
    public function create(StreamDto $dto, Channel $channel): Stream;
}
