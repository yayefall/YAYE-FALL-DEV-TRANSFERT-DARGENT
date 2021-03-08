<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use phpDocumentor\Reflection\File;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;

    }

    public function load(ObjectManager $manager)
    {


        $faker = Factory::create('fr_FR');


        for ($i = 0; $i < 4; $i++) {

            $user = new User();

            $user->setNom($faker->lastName);
            $user ->setPrenom($faker->firstName);
           // $user->setGenre($faker->randomElement(['Homme', 'Femme']));
            $user->setUsername($faker->userName);
            $user ->setEmail($faker->email);
            $user ->setTelephone($faker->phoneNumber);
            $user ->setPhoto($faker->randomElement(['photo']));
            $user->setArchivage(0);
           // $user->addAgence()
            $user ->setProfil($this->getReference(rand(0, 3)));
            $hash = $this->encoder->encodePassword($user, "password");
            $user ->setPassword($hash);

            $manager->persist($user);
        }
        $manager->flush();

    }
}
