<?php

namespace App\DataFixtures;

use Faker;

use App\Entity\ArticleReview;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleReviewFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $articleReview = new ArticleReview();

            $articleReview  ->setReview($faker->text)
                            ->setAuthor($this->getReference('User_' . rand(1, 9))->getFirstName())
                            ->setArticle($this->getReference('Article_' . rand(1, 9)));

            
            $manager->persist($articleReview);
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
