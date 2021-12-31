<?php

namespace App\Service\StreamSchedule\ScheduleRunner;

use App\Entity\Stream\StreamSchedule;
use App\Service\Stream\Manager\StreamManagerInterface;

final class DefaultScheduleRunner implements StreamScheduleRunnerInterface
{
    public function __construct(
        private StreamManagerInterface $manager,
    ) {}

    public function run(StreamSchedule $schedule): bool
    {
        if (null !== $schedule->getExecuted()) {
            return false;
        }
        $schedule->setExecuted(new \DateTime());
        $this->manager->startStream($schedule->getStream(), $schedule->getStream()->getChannel()->getAccount());

        return true;
    }
}
