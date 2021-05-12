<?php

namespace App\Repository\Stream\Doctrine;

use App\Entity\Stream\Channel;
use App\Entity\User\Account;
use App\Repository\AbstractDoctrineFilterRepository;
use App\Repository\Stream\ChannelRepositoryInterface;
use App\Filter\FilterInterface;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @method Channel|null find($id, $lockMode = null, $lockVersion = null)
 * @method Channel|null findOneBy(array $criteria, array $orderBy = null)
 * @method Channel[]    findAll()
 * @method Channel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChannelRepository extends AbstractDoctrineFilterRepository implements ChannelRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Channel::class);
    }

    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function findAllByFilter(Account $account, FilterInterface $filter): array
    {
        $alias = 'c';
        $qb = $this->createQueryBuilder($alias);
        $qb->andWhere($alias.'.account = :id')
            ->setParameter('id', $account->getId());

        return $this->findByFilterWithQueryBuilder($filter, $qb, $alias);
    }
}
