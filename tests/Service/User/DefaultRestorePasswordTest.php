<?php

namespace App\Tests\Service\User;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\User;
use App\Service\User\Manager\DefaultRestorePassword;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DefaultRestorePasswordTest extends BaseTestCase
{
    public function testGenerateToken()
    {
        $container = self::$container;

        /** @var DefaultRestorePassword $service */
        $service = $container->get(DefaultRestorePassword::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $regular);
        $this->assertInstanceOf(DefaultRestorePassword::class, $service);

        $this->assertNull($regular->getConfirmationToken());
        $service->generateToken($regular);
        $this->assertNotNull($regular->getConfirmationToken());
    }

    public function testRestorePassword() {
        $container = self::$container;

        /** @var DefaultRestorePassword $service */
        $service = $container->get(DefaultRestorePassword::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $regular */
        $regular = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $regular);
        $this->assertInstanceOf(DefaultRestorePassword::class, $service);

        $token = 'toknize';
        $password = 'tessdfsdfsfsdfsft';
        $regular->setConfirmationToken($token);
        $this->assertNotNull($regular->getConfirmationToken());
        $result = $service->restorePassword($regular, $password, $token);
        $this->assertTrue($result);

        /** @var UserPasswordEncoderInterface $encoder */
        $encoder = $container->get(UserPasswordEncoderInterface::class);

//        $encoded = $encoder->encodePassword($regular, $password);
//
//        $this->assertEquals($encoded, $regular->getPassword());
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
