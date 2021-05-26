<?php

namespace App\Tests\Service\User;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\User;
use App\Service\User\Manager\DefaultVerifier;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;

class DefaultVerifierTest extends BaseTestCase
{
    public function testVerifyUser()
    {
        $container = self::$container;

        /** @var DefaultVerifier $verifier */
        $verifier = $container->get(DefaultVerifier::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $regular);
        $this->assertInstanceOf(DefaultVerifier::class, $verifier);
        $this->assertFalse($regular->getIsActive());
        $this->assertEquals(null, $regular->getConfirmationToken());
        $verifier->generateToken($regular);
        $this->assertNotEquals(null, $regular->getConfirmationToken());
        $token = $regular->getConfirmationToken();
        $this->assertTrue($verifier->verify($regular, $token));
        $this->assertTrue($regular->getIsActive());
        $this->assertNull($regular->getConfirmationToken());
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
