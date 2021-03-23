<?php

namespace App\Repository\User;

interface UserRepositoryInterface
{
    public function find(int $id);
    public function findActive(int $id);
    public function findAll();
    public function findAllActive();
}
