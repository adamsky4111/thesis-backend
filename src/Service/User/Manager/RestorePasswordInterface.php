<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

interface RestorePasswordInterface
{
    public function generateToken(User $user);
    public function restorePassword(User $user, string $newPassword, $token): bool;
}
