<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

interface RestorePasswordInterface
{
    public function generateToken(User $user);
    public function restorePassword(string $newPassword, $token): bool;
}
