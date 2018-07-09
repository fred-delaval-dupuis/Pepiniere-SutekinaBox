<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Service;

class ServiceFixture extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var []
         */
        $services = [
            ['name' => 'Marketing'],
            ['name' => 'Purchases'],
            ['name' => 'RH'],
        ];

        $i = 1;
        foreach ($services as $service) {
            $serv = new Service($service['name']);

            $manager->persist($serv);

            $this->addReference('service_' . $i++, $serv);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }


}
