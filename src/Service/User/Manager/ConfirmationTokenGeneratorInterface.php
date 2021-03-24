<?php

namespace App\Service\User\Manager;

use App\Entity\User\User;

interface ConfirmationTokenGeneratorInterface
{
    public function generate(User $user);
}
