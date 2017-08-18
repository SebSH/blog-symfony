<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadUserData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {


        $user = new User();
        $user->setUsername('ruben');
        $user->setEmail('ruben@yahoo.fr');
        $user->setCreatedAt(new \DateTime());
        $user->setPassword('123456789');


        $manager->persist($user);

        $manager->flush();
    }


}