<?php

namespace App\DataFixtures;

use App\Entity\Program;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ProgramFixtures extends Fixture implements DependentFixtureInterface
{
    
    public const PROGRAMS = [
        [
            'title'     => 'Walking Dead', 
            'synopsis'  => 'Des zombies envahissent la terre', 
            'category'  => 'category_Horreur'
        ],
        [
            'title'     => 'Doctor Who', 
            'synopsis'  => 'Un voyageur de l\'espace-temps traverse l\'univers', 
            'category'  => 'category_Fantastique'
        ],
        [
            'title'     => 'Qu\'est ce-qu\'on a tous fait au bon dieu ?', 
            'synopsis'  => 'Une famille se retrouve embarassée pour le mariage de leurs enfants', 
            'category'  => 'category_Comédie'
        ],
        [
            'title'     => 'Indiana Jones', 
            'synopsis'  => 'Un courageux aventurier résoud des mystères antiques', 
            'category'  => 'category_Action'
        ],
        [
            'title'     => 'Harry Potter', 
            'synopsis'  => 'Un magicien a lunette veut sauver le monde des sorciers de Lord Voldemort', 
            'category'  => 'category_Fantastique'
        ],
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::PROGRAMS as $key => $programDetails)
        {
            // foreach($programDetails as $prog)
            // {
                $program = new Program();
                $program->setTitle($programDetails['title']);
                $program->setSynopsis($programDetails['synopsis']);
                $program->setCategory($this->getReference($programDetails['category']));
                $manager->persist($program);
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
