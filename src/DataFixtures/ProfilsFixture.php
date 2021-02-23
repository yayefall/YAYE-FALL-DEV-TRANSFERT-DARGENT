<?php

namespace App\DataFixtures;

use App\Entity\Profils;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProfilsFixture extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $times = 4;
        $profiles = ["AdminSysteme", "Caissier", "AdminAgence", "UserAgence"];
        for ($i = 0; $i < $times; $i++) {
            $profile = new Profils();
            $profile->setLibelle($profiles[$i]);
            $profile->setArchivage(0);
            $this->addReference($i, $profile);
            $manager->persist($profile);
        }

        $manager->flush();
    }


}
