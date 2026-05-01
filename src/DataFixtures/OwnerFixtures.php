<?php

namespace App\DataFixtures;

use App\Entity\Owner;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OwnerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $owner = new Owner();
        $faker = Factory::create( "fr_FR" );

        for ($i = 0; $i < 5; $i++) {
            $owner = new Owner();
            $owner->setName($faker->name());
            $owner->setEmail($faker->email());
            $manager->persist($owner);
        }
        $manager->flush();
    }
}
