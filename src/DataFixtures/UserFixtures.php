<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var EncoderFactoryInterface
     */
    private $factory;

    /**
     * UserFixtures constructor.
     * @param EncoderFactoryInterface $factory
     */
    public function __construct(EncoderFactoryInterface $factory)
    {
        $this->factory = $factory;
    }


    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'firstName' => 'John',
                'lastName'  => 'Doe',
                'email'     => 'john.doe@test.xyz',
                'password'  => 'testtest',
                'roles'     => new ArrayCollection([$this->getReference('role_3')]),
                'service'   => $this->getReference('service_1'),
            ],
            [
                'firstName' => 'Frédéric',
                'lastName'  => 'Delaval',
                'email'     => 'f.delaval@test.xyz',
                'password'  => 'testtest',
                'roles'     => new ArrayCollection([$this->getReference('role_5')]),
                'service'   => $this->getReference('service_3'),
            ],
            [
                'firstName' => 'Jane',
                'lastName'  => 'Doe',
                'email'     => 'jane.doe@test.xyz',
                'password'  => 'testtest',
                'roles'     => new ArrayCollection([$this->getReference('role_4')]),
                'service'   => $this->getReference('service_2'),
            ],
        ];

        foreach ($users as $user) {
            $u = new User($user['firstName'], $user['lastName'], $user['email'], '', $user['roles'], $user['service']);
            $encoder = $this->factory->getEncoder($u);
            $u->setPassword($encoder->encodePassword($user['password'], ''));
            $manager->persist($u);
        }

        $manager->flush();
    }

    /**
     * @return int|void
     */
    public function getOrder()
    {
        return 3;
    }


}
