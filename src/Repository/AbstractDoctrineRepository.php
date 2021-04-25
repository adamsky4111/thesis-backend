<?php

namespace App\Repository;

use App\Entity\User\Settings;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;


abstract class AbstractDoctrineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(Settings $settings, bool $flush = true): Settings
    {
        $em = $this->getEntityManager();
        $em->persist($settings);
        if ($flush) {
            $em->flush();
        }
        return $settings;
    }

    public function remove(Settings $settings, bool $flush = true): Settings
    {
        $em = $this->getEntityManager();
        $em->remove($settings);
        if ($flush) {
            $em->flush();
        }
        return $settings;
    }
}
