<?php

namespace App\Repository\User\Doctrine;

use App\Entity\User\Account;
use App\Entity\User\Settings;
use App\Repository\AbstractDoctrineFilterRepository;
use App\Repository\User\SettingsRepositoryInterface;
use App\Filter\FilterInterface;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @method Settings|null find($id, $lockMode = null, $lockVersion = null)
 * @method Settings|null findOneBy(array $criteria, array $orderBy = null)
 * @method Settings[]    findAll()
 * @method Settings[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SettingsRepository extends AbstractDoctrineFilterRepository implements SettingsRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Settings::class);
    }

    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function findByFilter(FilterInterface $filter, Account $account): array
    {
        $alias = 'o';

        $qb = $this->createQueryBuilder($alias);
        $qb->andWhere($alias.'.account = :id')
            ->setParameter('id', $account->getId());

        return $this->findByFilterWithQueryBuilder($filter, $qb, $alias);
    }
}
