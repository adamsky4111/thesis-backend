<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;
use App\Service\User\Dto\UserDto;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserManagerInterface
{
    public function get(int $id): null|User;
    public function getActive(int $id): null|User;
    public function getAll(): array;
    public function getAllActive(): array;
    public function getByUsernameOrEmail(string $phrase): ?User;
    public function register(UserDto $dto): User;
    public function create(UserDto $dto): User;
    public function update(UserDto $dto, User $user): User;
    public function delete(User $user): void;
    public function changeAvatar(UploadedFile $file, User $user): string;
}
