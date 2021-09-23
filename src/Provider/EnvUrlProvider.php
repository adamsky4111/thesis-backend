<?php

namespace App\Provider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EnvUrlProvider implements AppUrlProviderInterface, StreamAppUrlProviderInterface
{
    public function __construct(
        private ParameterBagInterface $params,
    ) {}

    public function getHostUrl(): string
    {
        return $this->params->get('app_url');
    }

    public function getStreamHostUrl(): string
    {
        return $this->params->get('stream_app_url');
    }
}
