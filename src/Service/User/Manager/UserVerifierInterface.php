<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

interface UserVerifierInterface
{
    public function generateToken(User $user);
    public function verify(User $user, $token): bool;
}
