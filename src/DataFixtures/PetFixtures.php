<?php

namespace App\DataFixtures;

use App\Entity\Pet;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PetFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=5; $i++) {
            $pet = new Pet;
            $pet->setPetname("Pet $i");
            $pet->setPetgender("Gender $i");
            $pet->setPettype("Type $i");
            $pet->setPetimage("https://icdn.dantri.com.vn/thumb_w/640/2020/11/28/meo-1-docx-1606522731922.png");
            $manager->persist($pet);
        }

        $manager->flush();
    }
}
