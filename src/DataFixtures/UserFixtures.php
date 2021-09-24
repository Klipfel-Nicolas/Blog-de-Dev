<?php
 
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker;

class UserFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            
            $user = new User();

            $user   ->setEmail($faker->email())
                    ->setPassword($this->passwordHasher->hashPassword(
                        $user,
                        'tekilatex'
                    ))
                    ->setFirstName($faker->firstName(null))
                    ->setLastName($faker->lastName())
                    ->setSlug(uniqid($user->getFirstName()))
                    ->setRoles(['ROLE_USER']);
                    
            $manager->persist($user);

            $this->addReference('User_' . $i, $user);
        }

        $manager->flush();
    } 
}
