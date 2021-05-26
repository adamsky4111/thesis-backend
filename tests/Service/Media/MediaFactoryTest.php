<?php

namespace App\Tests\Service\Media;

use App\DataFixtures\TestUserFixtures;
use App\Entity\User\Media;
use App\Entity\User\User;
use App\Service\Media\Factory\MediaFactory;
use App\Tests\Service\AbstractServiceTest as BaseTestCase;

class MediaFactoryTest extends BaseTestCase
{
    public function testCreateVideo()
    {
        $container = self::$container;

        /** @var MediaFactory $service */
        $service = $container->get(MediaFactory::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $user */
        $user = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(MediaFactory::class, $service);

        $media = $service->createVideo($user);
        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals(Media::VIDEO, $media->getType());
    }

    public function testCreateImage()
    {
        $container = self::$container;

        /** @var MediaFactory $service */
        $service = $container->get(MediaFactory::class);

        /** @var TestUserFixtures $fixture */
        $fixture = $container->get(TestUserFixtures::class);

        /** @var User $user */
        $user = $fixture->getReference(TestUserFixtures::USER_REGULAR);

        $this->assertInstanceOf(User::class, $user);
        $this->assertInstanceOf(MediaFactory::class, $service);

        $media = $service->createImage($user);
        $this->assertInstanceOf(Media::class, $media);
        $this->assertEquals(Media::IMAGE, $media->getType());
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
