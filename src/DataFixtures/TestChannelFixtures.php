<?php

namespace App\DataFixtures;

use App\Entity\User\User;
use App\Service\Stream\Factory\ChannelFactoryInterface;
use App\Service\User\Factory\UserFactoryInterface;
use App\Utils\Test\ChannelTestHelper;
use App\Utils\Test\UserTestHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestChannelFixtures extends Fixture implements OrderedFixtureInterface
{
    const USER_CHANNEL = 'test.user.channel';
    const CHANNEL = null;

    public function __construct(
        protected ChannelFactoryInterface $factory,
    ) { }

    public function load(ObjectManager $manager)
    {
        /** @var User $user */
        $user = $this->getReference(TestUserFixtures::USER_REGULAR);
        [$dto,] = ChannelTestHelper::createValidDto();
        $channel = $this->factory->create($dto, $user->getAccount());

        $manager->persist($channel);
        $manager->flush();

        $this->addReference(self::USER_CHANNEL, $channel);
    }

    public function getOrder(): int
    {
        return 10;
    }
}
