<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Stream\Stream;
use App\Filter\FilterInterface;
use App\Repository\AbstractDoctrineFilterRepository;
use App\Repository\Stream\StreamRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @method Stream|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stream|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stream[]    findAll()
 * @method Stream[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StreamRepository extends AbstractDoctrineFilterRepository implements StreamRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stream::class);
    }

    #[ArrayShape(['items' => "\int|mixed|string", 'total' => "int", 'pages' => "\float|int"])]
    public function searchByFilter(FilterInterface $filter): array
    {
        $alias = 's';
        $qb = $this->createQueryBuilder($alias);
        $qb->andWhere('s.isActive = 1');

        return $this->findByFilterWithQueryBuilder($filter, $qb, $alias);
    }

    public function findActive(int $id): ?Stream
    {
        return $this->findOneBy(['id' => $id, 'isActive' => true]);
    }
}
