<?php

namespace App\DataFixtures;

use App\Entity\Base\EntityInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TestFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
    }

    static function getFixtureByReference(string $ref): object
    {
        return (new TestFixtures)->getReference($ref);
    }
}
