<?php

namespace App\DataFixtures;

use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\User;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail("user@gmail.com");
        $password = $this->hasher->hashPassword($user, '123456');
        $user->setPassword($password);
        $user->setFirstName("First");
        $user->setLastName("Test");

        $manager->persist($user);
        $manager->flush();
    }
}