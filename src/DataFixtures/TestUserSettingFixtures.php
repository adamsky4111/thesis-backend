<?php

namespace App\DataFixtures;

use App\Service\Stream\Factory\SettingsFactoryInterface;
use App\Utils\Test\SettingTestHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestUserSettingFixtures extends Fixture implements OrderedFixtureInterface
{
    const USER_SETTINGS = 'test.user.regular.setrings';

    public function __construct(
        protected SettingsFactoryInterface $factory,
    ) { }

    public function load(ObjectManager $manager)
    {
        [$dto,] = SettingTestHelper::createValidDto();
        $user = $this->getReference(TestUserFixtures::USER_REGULAR);
        $s = $this->factory->create($dto, $user->getAccount());

        $manager->persist($s);
        $manager->flush();
        $this->addReference(self::USER_SETTINGS, $s);
    }

    public function getOrder(): int
    {
        return 6;
    }
}
