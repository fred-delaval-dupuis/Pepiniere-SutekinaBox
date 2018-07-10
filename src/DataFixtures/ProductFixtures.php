<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        $products = [
            new Product('Product1', 'Product1', 1000, 1, $this->getReference('supplier_1')),
            new Product('Product2', 'Product2', 1000, 1, $this->getReference('supplier_1')),
            new Product('Product3', 'Product3', 1000, 1, $this->getReference('supplier_1')),
            new Product('Product4', 'Product4', 1000, 1, $this->getReference('supplier_1')),
            new Product('Product5', 'Product5', 1000, 1, $this->getReference('supplier_1')),
        ];

        $i = 1;
        foreach ($products as $product) {
            $manager->persist($product);
            $this->addReference('product_' . $i++, $product);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 5;
    }


}
