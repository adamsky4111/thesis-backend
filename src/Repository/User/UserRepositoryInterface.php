<?php

namespace App\Repository\User;

use App\Entity\User\User;

interface UserRepositoryInterface
{
    public function find(int $id);
    public function findActive(int $id);
    public function findOneByUsername(string $username): ?User;
    public function findOneByEmail(string $email): ?User;
    public function findAll();
    public function findAllActive();
    public function upgradePassword(User $user, string $newEncodedPassword): void;
    public function save(User $user): User;
    public function findByEmailOrUsername(string $phrase): ?User;
}
