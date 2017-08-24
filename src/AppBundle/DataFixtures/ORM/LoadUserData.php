<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Admin;
use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{


    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {

        $johanAuthor = new User();
        $johanAuthor->setUsername('johan');
        $johanAuthor->setEmail('ruben@yahoo.fr');
        $johanAuthor->setCreatedAt(new \DateTime());
        $johanAuthor->setRoles('ROLE_AUTHOR');
        $johanAuthor->setPassword('123456789');


        $manager->persist($johanAuthor);

        $this->addReference('ruben', $johanAuthor);

        $manager->flush();


        $lisaAdmin = new Admin();
        $lisaAdmin->setUsername('lisa');
        $lisaAdmin->setRoles('ROLE_ADMIN');
        $lisaAdmin->setPassword('123456789');

        $manager->persist($lisaAdmin);

        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        // TODO: Implement setContainer() method.
    }


}