<?php

namespace App\Service\Stream\Provider;

use App\Dto\StreamDto;
use App\Provider\StreamAppUrlProviderInterface;

final class DefaultUrlProvider implements StreamUrlProviderInterface
{
    public function __construct(
        private StreamAppUrlProviderInterface $provider
    ) {}

    public function loadStreamUrl(StreamDto $stream): string
    {
        return $this->provider->getStreamHostUrl() . '?id=' . $stream->getId();
    }
}
