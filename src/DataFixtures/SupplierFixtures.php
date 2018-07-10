<?php

namespace App\DataFixtures;

use App\Entity\Supplier;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class SupplierFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $supplier = new Supplier('Supplier1', 'supplier1@test.xyz');

        $this->addReference('supplier_1', $supplier);

        $manager->persist($supplier);
        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }


}
