<?php

namespace App\Service\StreamSchedule\ScheduleRunner;

use App\Entity\Stream\StreamSchedule;

interface StreamScheduleRunnerInterface
{
    /**
     * @param StreamSchedule $schedule
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function run(StreamSchedule $schedule): bool;
}
