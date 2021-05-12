<?php

namespace App\Provider;

use App\Entity\User\User;
use App\Service\User\Dto\UserDto;

interface AppUrlProviderInterface
{
    public function getHostUrl(): string;
}
