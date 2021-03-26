<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Stream\Stream;
use App\Repository\Stream\StreamRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StreamRepository extends ServiceEntityRepository implements StreamRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stream::class);
    }

    public function save(Stream $stream, bool $flush = true): Stream
    {
        $em = $this->getEntityManager();
        $em->persist($stream);
        if ($flush) {
            $em->flush();
        }

        return $stream;
    }
}
