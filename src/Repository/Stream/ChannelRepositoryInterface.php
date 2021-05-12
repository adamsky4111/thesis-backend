<?php

namespace App\Repository\Stream;

use App\Entity\User\Account;
use App\Repository\RepositoryInterface;
use App\Filter\FilterInterface;

interface ChannelRepositoryInterface extends RepositoryInterface
{
    public function find(int $id);
    public function findAllByFilter(Account $account, FilterInterface $filter): array;
}
