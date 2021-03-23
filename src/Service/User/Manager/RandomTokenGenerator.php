<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

final class RandomTokenGenerator implements ConfirmationTokenGeneratorInterface
{
    public function generate(User $user)
    {
        $user->setConfirmationToken(bin2hex(random_bytes(16)));
    }
}
