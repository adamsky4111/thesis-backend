<?php

namespace App\Service\StreamSchedule\ScheduleApplier;

use App\Entity\Stream\Stream;

interface StreamScheduleApplierInterface
{
    /**
     * @param Stream $stream
     * @param bool $flush
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function schedule(Stream $stream, bool $flush = false): bool;
}
