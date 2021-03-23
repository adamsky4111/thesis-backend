<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

final class EqualTokenChecker implements ConfirmationTokenCheckerInterface
{
    public function check(User $user, string $token): bool
    {
        return ($user->getConfirmationToken() === $token);
    }
}
