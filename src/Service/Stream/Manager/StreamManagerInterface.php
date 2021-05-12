<?php

namespace App\Service\Stream\Manager;

use App\Dto\StreamDto;
use App\Entity\Stream\Stream;
use App\Entity\User\User;
use App\Filter\FilterInterface;

interface StreamManagerInterface
{
    public function getUserActualStream(User $user): ?StreamDto;
    public function getOr404(int $id): Stream;
    public function get(int $id): StreamDto;
    public function registerStream(StreamDto $dto): StreamDto;
    public function stopActualStream(): ?StreamDto;
    public function searchByFilter(FilterInterface $filter): array;
}
