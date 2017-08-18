<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Article;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadArticleData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $article = new Article();
        $article->setTitle('Mon Article');
        $article->setCreatedAt(new \DateTime());
        $article->setModifiedAt(new \DateTime());
        $article->setContent('test');




        $manager->persist($article);


        $manager->flush();
    }


}