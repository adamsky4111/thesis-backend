<?php

namespace App\Service\StreamSchedule\ScheduleGetter;

use App\Entity\Stream\StreamSchedule;
use App\Entity\User\User;

interface StreamScheduleGetterInterface
{
    public function getAllSchedule(): array;
    /**
     * @return StreamSchedule[]
     */
    public function getAllUserSchedule(User $user): array;
}
