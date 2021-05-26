<?php

namespace App\DataFixtures;

use App\Entity\Stream\Channel;
use App\Service\Stream\Factory\StreamFactoryInterface;
use App\Utils\Test\StreamTestHelper;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TestStreamFixtures extends Fixture implements OrderedFixtureInterface
{
    const USER_STREAM = 'test.stream.active';

    public function __construct(
        protected StreamFactoryInterface $factory,
    ) { }

    public function load(ObjectManager $manager)
    {
        [$dto,] = StreamTestHelper::createValidDto();
        /** @var Channel $channel */
        $channel = $this->getReference(TestChannelFixtures::USER_CHANNEL);

        $stream = $this->factory->create($dto, $channel);
        $manager->persist($stream);
        $manager->flush();
        $this->addReference(self::USER_STREAM, $stream);
    }

    public function getOrder(): int
    {
        return 15;
    }
}
