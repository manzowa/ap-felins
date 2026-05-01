<?php

namespace App\DataFixtures;

use App\Entity\Breed;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BreedFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $breed = new Breed();

        $cats = [
            [
                "race" => "Maine Coon",
                "description" => "Grand chat robuste avec un pelage épais. Très sociable et affectueux."
            ],
            [
                "race" => "Siamois",
                "description" => "Chat élégant aux yeux bleus, très vocal et attaché à son maître."
            ],
            [
                "race" => "Persan",
                "description" => "Chat calme avec un long pelage soyeux et un visage aplati."
            ],
            [
                "race" => "Bengal",
                "description" => "Chat actif au pelage tacheté, intelligent et joueur."
            ],
            [
                "race" => "Sphynx",
                "description" => "Chat sans poils, très affectueux et proche des humains."
            ]
        ];


        foreach ($cats as $cat) {
            $breed = new Breed();
            $breed->setName($cat["race"]);
            $breed->setDescription($cat["description"]);
            $manager->persist($breed);
        }
        $manager->flush();
    }
}
