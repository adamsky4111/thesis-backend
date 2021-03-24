<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Service\User\Dto\UserDto;

interface UserManagerInterface
{
    public function get(int $id): null|User;
    public function getActive(int $id): null|User;
    public function getAll(): array;
    public function getAllActive(): array;
    public function register(UserDto $dto): User;
    public function create(UserDto $dto): User;
    public function update(UserDto $dto, User $user): User;
    public function delete(User $user): void;
}
