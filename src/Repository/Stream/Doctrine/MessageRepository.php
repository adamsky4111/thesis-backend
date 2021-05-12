<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Base\EntityInterface;
use App\Entity\Stream\Message;
use App\Repository\AbstractDoctrineRepository;
use App\Repository\Stream\MessageRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Message|null find($id, $lockMode = null, $lockVersion = null)
 * @method Message|null findOneBy(array $criteria, array $orderBy = null)
 * @method Message[]    findAll()
 * @method Message[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MessageRepository extends AbstractDoctrineRepository implements MessageRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Message::class);
    }

    public function findActive(int $id): ?Message
    {
        return $this->findOneBy(['id' => $id, 'isDeleted' => false]);
    }
}
