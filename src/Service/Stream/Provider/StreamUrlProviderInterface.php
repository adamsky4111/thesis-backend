<?php

namespace App\Service\Stream\Provider;

use App\Dto\StreamDto;

interface StreamUrlProviderInterface
{
    public function loadStreamUrl(StreamDto $stream): string;
}
