<?php

namespace App\Service\StreamSchedule\ScheduleGetter;

use App\Entity\Stream\StreamSchedule;
use App\Entity\User\User;
use Doctrine\ORM\EntityManagerInterface;

final class DoctrineStreamScheduleGetter implements StreamScheduleGetterInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}

    public function getAllSchedule(): array
    {
        $repo = $this->entityManager->getRepository(StreamSchedule::class);
        return $repo->findBy(['executed' => null]);
    }

    public function getAllUserSchedule(User $user): array
    {
        return $this->entityManager
            ->getRepository(StreamSchedule::class)
            ->createQueryBuilder('ss')
            ->leftJoin('ss.stream', 'stream')
            ->leftJoin('stream.channel', 'channel')
            ->leftJoin('channel.account', 'account')
            ->andWhere('account.id = :account')
            ->andWhere('ss.executed IS NULL')
            ->orderBy('stream.startingAt', 'DESC')
            ->setParameter('account', $user->getAccount()->getId())
            ->getQuery()
            ->getResult()
            ;
    }
}
