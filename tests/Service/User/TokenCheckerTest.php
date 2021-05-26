<?php

namespace App\Tests\Service\User;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\User;
use App\Service\User\Manager\ConfirmationTokenCheckerInterface;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;

class TokenCheckerTest extends BaseTestCase
{
    public function testChecker()
    {
        $container = self::$container;

        /** @var ConfirmationTokenCheckerInterface $generator */
        $checker = $container->get(ConfirmationTokenCheckerInterface::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $token = 'test-test-token';

        $this->assertInstanceOf(User::class, $regular);
        $this->assertEquals(null, $regular->getConfirmationToken());
        $regular->setConfirmationToken($token);
        $this->assertEquals($token, $regular->getConfirmationToken());
        $this->assertTrue($checker->check($regular, $token));
        $this->assertFalse($checker->check($regular, $token.'2'));
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
