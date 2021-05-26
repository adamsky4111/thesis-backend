<?php

namespace App\DataFixtures;

use App\Service\Stream\Factory\SettingsFactoryInterface;
use App\Service\User\Factory\UserFactoryInterface;
use App\Utils\Test\UserTestHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestUserFixtures extends Fixture implements OrderedFixtureInterface
{
    const USER_REGULAR = 'test.user.regular';
    const USER_STREAM = 'test.user.regular';

    public function __construct(
        protected UserFactoryInterface $factory,
        protected SettingsFactoryInterface $settingsFactory,
    ) { }

    public function load(ObjectManager $manager)
    {
        [$dto,] = UserTestHelper::createValidUserDto();
        $regular = $this->factory->create($dto);


        $manager->persist($regular);
        $manager->flush();

        [$dto,] = UserTestHelper::createValidUserDto(
            username: 'testowy',
            email: 'emailstream@gmail.com'
        );
        $stream = $this->factory->create($dto);

        $manager->persist($stream);
        $manager->flush();

        $this->addReference(self::USER_STREAM, $stream);
    }

    public function getOrder(): int
    {
        return 5;
    }
}
