<?php

namespace App\DataFixtures;


use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlantFixtures extends Fixture
{
    public function getPlantFamily(ObjectManager$manager, $code): PlantFamily
    {
        return $manager->getRepository("App\Entity\Plant\PlantFamily")->findOneBy(array('code' => $code));
    }

    public function load(ObjectManager $manager)
    {
        $plant1 = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            $this->getPlantFamily($manager, 'fructable'), //TODO get by code
            12
        );

        $plant2 = new Plant(
            'Pommier',
            'Malus',
            '',
            $this->getPlantFamily($manager, 'fructable'),
            12
        );
        $plant3 = new Plant(
            'Carotte',
            'Daucus carota',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $plant4 = new Plant(
            'Radis',
            'Raphanus sativus',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $plant5 = new Plant(
            'Géranium',
            'Geranium',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $plant6 = new Plant(
            'Jonquille véritable',
            'Narcissus jonquilla',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $plant7 = new Plant(
            'Sapin',
            'Abies',
            '',
            $this->getPlantFamily($manager, 'other'),
            1
        );
        $plant8 = new Plant(
            'Fougère',
            'Filicophyta',
            '',
            $this->getPlantFamily($manager, 'other'),
            12
        );

        $manager->persist($plant1);
        $manager->persist($plant2);
        $manager->persist($plant3);
        $manager->persist($plant4);
        $manager->persist($plant5);
        $manager->persist($plant6);
        $manager->persist($plant7);
        $manager->persist($plant8);

        $manager->flush();
    }
}