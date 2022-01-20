<?php

namespace App\Command;

use App\Service\StreamSchedule\ScheduleGetter\StreamScheduleGetterInterface;
use App\Service\StreamSchedule\ScheduleRunner\StreamScheduleRunnerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ScheduleStreamCommand extends Command
{
    protected StreamScheduleRunnerInterface $runner;
    protected StreamScheduleGetterInterface $getter;

    protected static $defaultName = 'app:schedule:stream:run';
    protected static string $defaultDescription = 'Run schedule streams';

    public function __construct(StreamScheduleRunnerInterface $runner, StreamScheduleGetterInterface $getter, string $name = null)
    {
        $this->runner = $runner;
        $this->getter = $getter;
        parent::__construct($name);
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $schedules = $this->getter->getAllSchedule();
        foreach ($schedules as $schedule) {
            $this->runner->run($schedule);
        }

        return 0;
    }
}