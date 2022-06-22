<?php

namespace App\DataFixtures;

use App\Entity\Receipt;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ReceiptFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=5; $i++) {
            $receipt = new Receipt;
            $receipt->setPetname("Pet $i");
            $receipt->setBuyername("Buyername $i");
            $receipt->setPrice((float)(rand(1200,1300)));
            $receipt->setDatecreate(\DateTime::createFromFormat('Y-m-d','2022-06-22'));              
            $manager->persist($receipt);
        }

        $manager->flush();
    }
}
