<?php

namespace App\DataFixtures;


use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Plant\SoilType;
use App\Entity\Plant\SunExposureType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PlantFixtures extends Fixture
{
    public function getPlantFamily(ObjectManager$manager, $code): PlantFamily
    {
        return $manager->getRepository("App\Entity\Plant\PlantFamily")->findOneBy(array('code' => $code));
    }

    public function getClimaticArea(ObjectManager $manager, string $code): ClimaticArea
    {
        return $manager->getRepository("App\Entity\Plant\ClimaticArea")->findOneBy(array('code' => $code));
    }

    public function getSoilType(ObjectManager $manager, string $code): SoilType
    {
        return $manager->getRepository("App\Entity\Plant\SoilType")->findOneBy(array('code' => $code));
    }

    public function getSunExposureType(ObjectManager $manager, string $code): SunExposureType
    {
        return $manager->getRepository("App\Entity\Plant\SunExposureType")->findOneBy(array('code' => $code));
    }

    public function getPlantingDateInterval(ObjectManager $manager, string $climaticAreaCode, int $numMonthBegin, int $numMonthEnd): PlantingDateInterval
    {
        $monthBegin = $manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthBegin));
        $monthEnd = $manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthEnd));
        return $manager->getRepository("App\Entity\Plant\PlantingDateInterval")->findOneBy(array(
            'climaticArea' => $this->getClimaticArea($manager, $climaticAreaCode),
            'monthBegin' => $monthBegin,
            'monthEnd' => $monthEnd
        ));
    }

    public function load(ObjectManager $manager)
    {
        $plant1 = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            $this->getPlantFamily($manager, 'fructable'),
            12
        );
        $plant1->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 10));
        $plant1->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 9));
        $plant1->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 8));
        $plant1->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $plant1->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant1->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));

        $plant2 = new Plant(
            'Pommier',
            'Malus',
            '',
            $this->getPlantFamily($manager, 'fructable'),
            12
        );
        $plant2->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 2));
        $plant2->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 11, 2));
        $plant2->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 11, 2));
        $plant2->addPreferedSoilType($this->getSoilType($manager, 'limestone'));
        $plant2->addPreferedSoilType($this->getSoilType($manager, 'silica'));
        $plant2->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant2->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));

        $plant3 = new Plant(
            'Carotte',
            'Daucus carota',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $plant3->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 4, 7));
        $plant3->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 7));
        $plant3->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 6));
        $plant3->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $plant3->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant3->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));

        $plant4 = new Plant(
            'Radis',
            'Raphanus sativus',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $plant4->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 4, 6));
        $plant4->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 6));
        $plant4->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 5));
        $plant4->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $plant4->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant4->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $plant4->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));

        $plant5 = new Plant(
            'Géranium',
            'Geranium',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $plant5->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 10));
        $plant5->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 5, 10));
        $plant5->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 9));
        $plant5->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant5->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $plant5->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));
        $plant5->addPreferedSunExposureType($this->getSunExposureType($manager, 'shadow'));

        $plant6 = new Plant(
            'Jonquille véritable',
            'Narcissus jonquilla',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $plant6->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 6));
        $plant6->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 10, 5));
        $plant6->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 9, 4));
        $plant6->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $plant6->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $plant6->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));

        $plant7 = new Plant(
            'Sapin',
            'Abies',
            '',
            $this->getPlantFamily($manager, 'other'),
            1
        );
        $plant7->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 11));
        $plant7->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 10));
        $plant7->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 10));
        $plant7->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $plant7->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));

        $plant8 = new Plant(
            'Fougère',
            'Filicophyta',
            '',
            $this->getPlantFamily($manager, 'other'),
            12
        );
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 11));
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 10));
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 10));
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 5));
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 10, 4));
        $plant8->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 10, 4));
        $plant8->addPreferedSoilType($this->getSoilType($manager, 'peaty'));
        $plant8->addPreferedSunExposureType($this->getSunExposureType($manager, 'shadow'));
        $plant8->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));

        foreach ([$plant1, $plant2, $plant3, $plant4, $plant5, $plant6, $plant7, $plant8] as $obj) {
            $manager->persist($obj);
        }

        $manager->flush();
    }
}