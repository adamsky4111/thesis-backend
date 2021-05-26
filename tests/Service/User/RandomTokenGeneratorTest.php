<?php

namespace App\Tests\Service\User;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\User;
use App\Service\User\Manager\ConfirmationTokenGeneratorInterface;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;

class RandomTokenGeneratorTest extends BaseTestCase
{
    public function testConfirmationToken()
    {
        $container = self::$container;

        /** @var ConfirmationTokenGeneratorInterface $generator */
        $generator = $container->get(ConfirmationTokenGeneratorInterface::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $regular);
        $this->assertEquals(null, $regular->getConfirmationToken());
        $generator->generate($regular);
        $this->assertNotEquals(null, $regular->getConfirmationToken());
    }

    public function setFixtures(): void
    {
        $this->fixtures = [
            TestUserFixtures::class
        ];
    }

    protected function setServices(): void
    {
        // TODO: Implement setServices() method.
    }
}
