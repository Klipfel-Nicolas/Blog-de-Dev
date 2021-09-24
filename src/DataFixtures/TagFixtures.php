<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Service\Slugify;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class TagFixtures extends Fixture implements OrderedFixtureInterface
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
            
            $tag = new Tag();

            $tag->setIntitule($faker->word())
                ->setSlug($tag->getIntitule());

            $manager->persist($tag);

            $this->addReference('Tag_' . $i, $tag);
        }
        
        $manager->flush();
    }

    /** 
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 1;
    } 
}
