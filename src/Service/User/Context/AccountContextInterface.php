<?php

namespace App\Service\User\Context;

use App\Entity\User\Account;

interface AccountContextInterface
{
    public function getAccount(): ?Account;
}
