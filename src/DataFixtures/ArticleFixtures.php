<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use App\Entity\Tag;
use App\Service\Slugify;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class ArticleFixtures extends Fixture 
{

    private $slugify;

    /**
     * @param ObjectManager $manager
     */
    public function __construct(Slugify $slugify)
    {
        $this->slugify = $slugify;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $article = new Article();

            $article->setTitle($faker->sentence(7, true))
                    ->setContent($faker->text)
                    ->setPoster('dev.jpg');
            $slug = $this->slugify->generate($article->getTitle());
            $article->setSlug($slug);
            
            
            for($j = 0; $j < rand(1 , 4); $j++){
               $article->addTag($this->getReference('Tag_' . rand(1, 9))); 
            }

            $manager->persist($article);

            $this->addReference('Article_' . $i, $article);
        }

        $manager->flush();
    }

}
