<?php

namespace App\DataFixtures;

use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
//Tout d'abord nous ajoutons la classe Factory de FakerPhp
use Faker\Factory;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        //Puis ici nous demandons à la Factory de nous fournir un Faker
        $faker = Factory::create();

        /**
        * L'objet $faker que tu récupère est l'outil qui va te permettre 
        * de te générer toutes les données que tu souhaites
        */
        for($p = 1; $p <= count(ProgramFixtures::PROGRAMS); $p++) {
            for($i = 1; $i <= 5; $i++) {
                $season = new Season();
                //Ce Faker va nous permettre d'alimen;lter l'instance de Season que l'on souhaite ajouter en base
                $season->setNumber($i);
                $season->setYear($faker->year());
                $season->setDescription($faker->paragraphs(3, true));
                $season->setProgram($this->getReference('program_' . $p));
                $manager->persist($season);
                $this->setReference('season_' . $i, $season);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
          ProgramFixtures::class,
        ];
    }
}