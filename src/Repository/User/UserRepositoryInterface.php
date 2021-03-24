<?php

namespace App\Repository\User;

use App\Entity\User\User;

interface UserRepositoryInterface
{
    public function find(int $id);
    public function findActive(int $id);
    public function findAll();
    public function findAllActive();
    public function upgradePassword(User $user, string $newEncodedPassword): void;
    public function save(User $user): User;
}
