<?php

namespace App\Service\Stream\Manager;

use App\Dto\StreamDto;
use App\Entity\User\User;

interface StreamManagerInterface
{
    public function getUserActualStream(User $user): ?StreamDto;
    public function registerStream(StreamDto $dto): StreamDto;
    public function stopActualStream(): ?StreamDto;
}
