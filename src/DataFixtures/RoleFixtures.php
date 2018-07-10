<?php

namespace App\DataFixtures;

use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class RoleFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        /**
         * @var Role[]
         */
        $roles = [
            'ROLE_ADMIN',
            'ROLE_USER',
            'ROLE_BOX_CREATOR',
            'ROLE_BOX_VALIDATOR',
            'ROLE_SUPER_ADMIN',
        ];

        $i = 1;

        foreach ($roles as $role) {
            $r = new Role($role);
            $manager->persist($r);
            $this->addReference('role_' . $i++, $r);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }


}
