<?php

namespace App\DataFixtures;

use App\Entity\Ressource;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RessourceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $name = [
            "FromScratch",
            "Open Class Room",
            "The Net Ninja",
            "Udemy",
            "Js30",
            "Symphony en 1h",
            "Awwwards",
            "Codrops",
            "CSS Tricks",
            "Graphiste Blog"
        ];

        $posters = [
            "fromScratch1.jpeg",
            "openclassroom.jpeg",
            "netNinja.png",
            "udemy.png",
            "js30.png",
            "liorChamla.jpeg",
            "awwwards.jpeg",
            "codrops.png",
            "cssTricks.png",
            "graphiste.jpeg"
        ];

        $url = [
            "https://www.youtube.com/watch?v=K3D2rjAUQ3o",
            "https://openclassrooms.com/fr/",
            "https://www.youtube.com/watch?v=YrxBCBibVo0&list=PL4cUxeGkcC9hYYGbV60Vq3IXYNfDk8At1",
            "https://www.udemy.com/",
            "https://javascript30.com/",
            "https://www.youtube.com/watch?v=UTusmVpwJXo",
            "https://www.awwwards.com/",
            "https://tympanus.net/codrops/",
            "https://css-tricks.com/",
            "https://graphiste.com/blog/"
        ];

        for ($i = 0; $i < 10; $i++) {
            $ressource = new Ressource();

            $ressource  ->setName($name[$i])
                        ->setUrl($url[$i])
                        ->setDescription($faker->text)
                        ->setPoster($posters[$i]);
       
            
            for($j = 0; $j < rand(1 , 4); $j++){
               $ressource->addTag($this->getReference('Tag_' . rand(1, 9))); 
            }

            $manager->persist($ressource);

            $this->addReference('Ressource_' . $i, $ressource);
        }

        $manager->flush();
    }
}
