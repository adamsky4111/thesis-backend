<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

interface ConfirmationTokenCheckerInterface
{
    public function check(User $user, string $token): bool;
}
