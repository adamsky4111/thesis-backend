<?php

namespace App\Provider;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class EnvUrlProvider implements AppUrlProviderInterface
{
    public function __construct(
        private ParameterBagInterface $params,
    ) {}

    public function getHostUrl(): string
    {
        return $this->params->get('app_url');
    }
}
