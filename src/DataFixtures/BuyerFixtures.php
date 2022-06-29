<?php

namespace App\DataFixtures;

use App\Entity\Buyer;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class BuyerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=5; $i++) {
            $buyer = new Buyer;
            $buyer->setBuyername("Buyername $i");
            $buyer->setBuyerphone("Buyerphone $i");
            $buyer->setBuyeraddress("Buyeraddress $i");   
            $manager->persist($buyer);
        }

        $manager->flush();
    }
}
