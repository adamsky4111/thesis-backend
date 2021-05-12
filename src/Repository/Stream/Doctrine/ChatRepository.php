<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Stream\Chat;
use App\Repository\AbstractDoctrineRepository;
use App\Repository\Stream\ChatRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Chat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Chat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Chat[]    findAll()
 * @method Chat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChatRepository extends AbstractDoctrineRepository implements ChatRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Chat::class);
    }

    public function findActive(int $id): Chat|null
    {
        return $this->find($id);
    }
}
