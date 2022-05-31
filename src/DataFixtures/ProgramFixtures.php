<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    
    public const PROGRAMS = [
        [
            'title'     => 'Walking Dead', 
            'synopsis'  => 'Des zombies envahissent la terre', 
            'category'  => 'category_Horreur',
            'country'   => 'USA',
        ],
        [
            'title'     => 'Doctor Who', 
            'synopsis'  => 'Un voyageur de l\'espace-temps traverse l\'univers', 
            'category'  => 'category_Fantastique',
            'country'   => 'Royaume-Uni',
        ],
        [
            'title'     => 'Qu\'est ce-qu\'on a tous fait au bon dieu ?', 
            'synopsis'  => 'Une famille se retrouve embarassée pour le mariage de leurs enfants', 
            'category'  => 'category_Comédie',
            'country'   => 'France',
        ],
        [
            'title'     => 'Indiana Jones', 
            'synopsis'  => 'Un courageux aventurier résoud des mystères antiques', 
            'category'  => 'category_Action',
            'country'   => 'USA',
        ],
        [
            'title'     => 'Harry Potter', 
            'synopsis'  => 'Un magicien a lunette veut sauver le monde des sorciers de Lord Voldemort', 
            'category'  => 'category_Fantastique',
            'country'   => 'Royaume-Uni',
        ],
        [
            'title'     => 'Freddy, les griffes de la nuit', 
            'synopsis'  => 'Dormir c\est mourir. Prenez garde...', 
            'category'  => 'category_Horreur',
            'country'   => 'USA',
        ],
        [
            'title'     => 'Massacre à la tronçonneuse', 
            'synopsis'  => 'Dans la paisible ville de Cristal Lake, un psychopate fou muni d\'une machette et d\'un masque sème la terreur', 
            'category'  => 'category_Horreur',
            'country'   => 'USA',
        ],
    ];

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();
        $i = 1;
        foreach(self::PROGRAMS as $key => $programDetails)
        {
            // foreach($programDetails as $prog)
            // {
                $program = new Program();
                $program->setTitle($programDetails['title']);
                $program->setSynopsis($programDetails['synopsis']);
                $program->setCategory($this->getReference($programDetails['category']));
                $program->setYear($faker->year());
                $program->setCountry($programDetails['country']);
                $manager->persist($program);
                $this->addReference('program_' . $i, $program);
                $i++;
            // }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          CategoryFixtures::class,
        ];
    }


}
