<?php

namespace App\Service\User\Context;

use App\Entity\User\User;
use Symfony\Component\Security\Core\Security;

final class UserContext implements UserContextInterface
{
    public function __construct(
        private Security $security,
    ) {}

    public function getUser(): ?User
    {
        return $this->getUser();
    }
}
