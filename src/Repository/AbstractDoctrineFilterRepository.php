<?php

namespace App\Repository;

use App\Service\Stream\Filter\FilterInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

abstract class AbstractDoctrineFilterRepository extends AbstractDoctrineRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    #[ArrayShape([
        'items' => "array",
        'total' => "int",
        'pages' => "int"
    ])]
    public function findByFilter(FilterInterface $filter): array
    {
        $alias = 'o';

        $qb = $this->createQueryBuilder($alias);

        $counter = [
            FilterInterface::TYPE_PHRASE => 1,
            FilterInterface::TYPE_BOOLEAN => 1,
            FilterInterface::TYPE_FROM_TO => 1,
        ];

        $mapper = $filter->getTypeMapper();

        foreach ($filter->getFindBy() as $field=>$value) {
            $type = $mapper[$field];
            $isSupported = $filter->isAllowedField($field);
            if ($isSupported && null !== $value && "" !== $value) {
                switch ($type) {
                    case FilterInterface::TYPE_PHRASE:
                        $qb->andWhere($alias.'.'.$field.' LIKE :phrase'.$counter[FilterInterface::TYPE_PHRASE])
                            ->setParameter('phrase'.$counter[FilterInterface::TYPE_PHRASE], $filter->getLike($value));
                        ++$counter[FilterInterface::TYPE_PHRASE];
                        break;
                    case FilterInterface::TYPE_BOOLEAN:
                        $qb->andWhere($alias.'.'.$field.' = :boolean'.$counter[FilterInterface::TYPE_BOOLEAN])
                            ->setParameter('boolean'.$counter[FilterInterface::TYPE_BOOLEAN], (true === $value) ? '1' : '0');
                        ++$counter[FilterInterface::TYPE_BOOLEAN];
                        break;
                    case FilterInterface::TYPE_FROM_TO:
                        if (isset($value['min']) && null !== $value['min']) {
                            $qb->andWhere($alias.'.'.$field.' > :min'.$counter[FilterInterface::TYPE_FROM_TO])
                                ->setParameter('min'.$counter[FilterInterface::TYPE_FROM_TO], $value['min']);
                        }
                        if (isset($value['min']) && null !== $value['max']) {
                            $qb->andWhere($alias.'.'.$field.' < :max'.$counter[FilterInterface::TYPE_FROM_TO])
                                ->setParameter('max'.$counter[FilterInterface::TYPE_FROM_TO], $value['max']);
                        }

                        ++$counter[FilterInterface::TYPE_FROM_TO];
                }
            }
        }

        foreach ($filter->getSortBy() as $field=>$value) {
            if (!in_array($value, ['ASC', 'DESC'])) {
                continue;
            }
            $isSupported = $filter->isAllowedSort($field);

            if ($isSupported) {
                $qb->addOrderBy($alias.'.'.$field, $value);
            }
        }

        if ($filter->isPaginated()) {
            $paginator = new Paginator($qb->getQuery());
            $total = count($paginator);
            $pages = ceil($total / $filter->getPerPage());

            $items = $paginator
                ->getQuery()
                ->setFirstResult($filter->getPerPage() * ($filter->getPage()-1))
                ->setMaxResults($filter->getPerPage())
                ->getResult();
        } else {
            $items = $qb->getQuery()->getResult();
            $total = \count($items);
            $pages = 1;
        }

        return [
            'items' => $items,
            'total' => $total,
            'pages' => $pages,
        ];
    }
}
