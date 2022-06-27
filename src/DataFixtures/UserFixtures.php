<?php

namespace App\DataFixtures;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LoginFixtures extends Fixture
{
    public function __construct (UserPasswordHasherInterface $hasher) {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $user = new User;
        $user->setUsername("User");
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $user->setRoles(['ROLE_USER']);
        $manager->persist($user);

        $user = new User;
        $user->setUsername("Admin");
        $user->setPassword($this->hasher->hashPassword($user,"123456"));
        $user->setRoles(['ROLE_ADMIN']);
        $manager->persist($user);

        $manager->flush();
    }
}
