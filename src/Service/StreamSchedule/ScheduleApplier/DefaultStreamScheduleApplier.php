<?php

namespace App\Service\StreamSchedule\ScheduleApplier;

use App\Entity\Stream\Stream;
use App\Entity\Stream\StreamSchedule;
use Doctrine\ORM\EntityManagerInterface;

final class DefaultStreamScheduleApplier implements StreamScheduleApplierInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function schedule(Stream $stream, bool $flush = false): bool
    {
        $repository = $this->entityManager->getRepository(StreamSchedule::class);
        $existing = $repository->findBy(['stream' => $stream]);
        if (!empty($existing)) {
            throw new \InvalidArgumentException();
        }
        $schedule = new StreamSchedule($stream);
        $schedule->setExecuted(null);
        $schedule->setCreatedAt(new \DateTime());
        $this->entityManager->persist($schedule);
        if ($flush) {
            $this->entityManager->flush();
        }

        return true;
    }
}
