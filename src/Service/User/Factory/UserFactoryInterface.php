<?php

namespace App\Service\User\Factory;

use App\Entity\User\User;
use App\Service\User\Dto\UserDto;

interface UserFactoryInterface
{
    public function create(UserDto $dto): User;
    public function update(UserDto $dto, User $user): User;
}
