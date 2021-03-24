<?php

namespace App\Service\User\Context;

use App\Entity\User\Account;

final class AccountContext implements AccountContextInterface
{
    public function __construct(
        private UserContextInterface $user,
    ) {}

    public function getAccount(): ?Account
    {
        return $this->user->getUser()?->getAccount();
    }
}
