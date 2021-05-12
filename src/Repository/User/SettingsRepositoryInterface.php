<?php

namespace App\Repository\User;

use App\Entity\User\Account;
use App\Repository\RepositoryInterface;
use App\Filter\FilterInterface;
use JetBrains\PhpStorm\ArrayShape;

interface SettingsRepositoryInterface extends RepositoryInterface
{
    public function find(int $id);
    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function findByFilter(FilterInterface $filter, Account $account): array;
}
