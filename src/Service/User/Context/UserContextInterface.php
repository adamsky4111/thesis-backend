<?php

namespace App\Service\User\Context;

use App\Entity\User\User;

interface UserContextInterface
{
    public function getUser(): ?User;
}
