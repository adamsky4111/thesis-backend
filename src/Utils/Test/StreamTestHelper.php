<?php

namespace App\Utils\Test;

use App\Dto\StreamDto;
use JetBrains\PhpStorm\Pure;

class StreamTestHelper
{
    public static function createValidDto(): array
    {
        $name = 'stream1';
        $description = 'desc';
        $startingNow = true;
        $startingAt = new \DateTime();
        $endingAt = (new \DateTime())->modify('+1 hour');
        $dto = new StreamDto(null, $name, $description, $startingNow, $startingAt, $endingAt);
        return [$dto, [$name, $description, $startingNow, $startingAt, $endingAt]];
    }
}