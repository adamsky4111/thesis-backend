<?php

namespace App\Tests;

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\Common\DataFixtures\ReferenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class AbstractTestCase extends WebTestCase
{
    protected ?EntityManagerInterface $entityManager = null;
    protected array $fixtures;
    protected ?Loader $fixtureLoader = null;
    protected ?ORMPurger $purger = null;
    protected ?ORMExecutor $executor = null;
    protected ?ReferenceRepository $references = null;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->setFixtures();
        $this->loadFixtures();
    }

    abstract function setFixtures(): void;

    protected function getEntityManager(): EntityManagerInterface
    {
        $container = self::$container;
        if (!$this->entityManager) {
            $this->entityManager = $container->get(EntityManagerInterface::class);
        }

        return $this->entityManager;
    }

    protected function loadFixtures()
    {
        $loader = $this->getFixtureLoader();
        foreach ($this->fixtures as $fixture) {
            /** @var FixtureInterface $obj */
            $obj = self::$container->get($fixture);
            $loader->addFixture($obj);
        }

         $this->getExecutor()->execute(
                $this->fixtureLoader->getFixtures()
            );
    }

    protected function getReferenceOfClass(string $reference, string $expectedClass): object
    {
        $obj = $this->getReference($reference);
        $this->assertInstanceOf($expectedClass, $obj);

        return $obj;
    }

    protected function getReference(string $reference): object
    {
        return $this->getReferenceRepository()->getReference($reference);
    }

    protected function getReferenceRepository(): ReferenceRepository
    {
        if (!$this->references) {
            $this->references = $this->getExecutor()->getReferenceRepository();
        }

        return $this->references;
    }

    protected function getFixtureLoader(): Loader
    {
        if (!$this->fixtureLoader) {
            $this->fixtureLoader = new Loader();
        }

        return $this->fixtureLoader;
    }

    protected function getPurger(): ORMPurger
    {
        if (!$this->purger) {
            $this->purger = new ORMPurger($this->getEntityManager());
            $this->purger->getObjectManager()->getConnection()->query('SET FOREIGN_KEY_CHECKS=0');
        }

        return $this->purger;
    }

    protected function getExecutor(): ORMExecutor
    {
        if (!$this->executor) {
            $this->executor = new ORMExecutor($this->getEntityManager(), $this->getPurger());
        }

        return $this->executor;
    }
}
