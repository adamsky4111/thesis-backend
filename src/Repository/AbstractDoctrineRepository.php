<?php

namespace App\Repository;

use App\Entity\Base\EntityInterface;
use App\Entity\User\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


abstract class AbstractDoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(EntityInterface $entity, bool $flush = true): EntityInterface
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        if ($flush) {
            $em->flush();
        }
        return $entity;
    }

    public function remove(EntityInterface $entity, bool $flush = true): EntityInterface
    {
        $em = $this->getEntityManager();
        $em->remove($entity);
        if ($flush) {
            $em->flush();
        }
        return $entity;
    }
}
