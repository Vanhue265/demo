<?php

namespace App\DataFixtures;

use App\Entity\Staff;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class StaffFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i=1; $i<=5; $i++) {
            $staff = new Staff;
            $staff->setStaffname("Staffname $i");
            $staff->setStaffphone("Staffphone $i");
            $staff->setStaffaddress("Staffaddress $i");   
            $manager->persist($staff);
        }

        $manager->flush();
    }
}
