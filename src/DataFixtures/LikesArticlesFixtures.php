<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\Entity\ArticleLikes;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class LikesArticlesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        for ($i = 0; $i < 10; $i++) {

            $like = new ArticleLikes();

            $like   ->setArticle($this->getReference('Article_' . rand(1, 9)))
                    ->setUser($this->getReference('User_' . rand(1, 9)));

            $manager->persist($like);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ArticleFixtures::class
        ];
    }
}
