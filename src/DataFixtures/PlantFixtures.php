<?php

namespace App\DataFixtures;


use App\Entity\Plant\ClimaticArea;
use App\Entity\Plant\FertilizerType;
use App\Entity\Plant\LifeCycleStep;
use App\Entity\Plant\Plant;
use App\Entity\Plant\PlantFamily;
use App\Entity\Plant\PlantFertilizerType;
use App\Entity\Plant\PlantingDateInterval;
use App\Entity\Plant\PlantLifeCycleStep;
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

    public function getFertilizerType(ObjectManager $manager, string $code): FertilizerType
    {
        return $manager->getRepository("App\Entity\Plant\FertilizerType")->findOneBy(array('code' => $code));
    }

    public function getLifeCycleStep(ObjectManager $manager, string $code): LifeCycleStep
    {
        return $manager->getRepository("App\Entity\Plant\LifeCycleStep")->findOneBy(array('code' => $code));
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
        $tomato = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            $this->getPlantFamily($manager, 'fructable'),
            12
        );
        $tomato->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 10));
        $tomato->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 9));
        $tomato->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 8));
        $tomato->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $tomato->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $tomato->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $tomato->addPreferedFertilizerType(new PlantFertilizerType($tomato, $this->getFertilizerType($manager, 'N-K'), 9));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStep($manager, 'germing'), 9, 1));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStep($manager, 'growth'), 120, 2));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStep($manager, 'flowering'), 7, 3));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStep($manager, 'fruct'), 45, 4));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStep($manager, 'harvest'), 7, 5));

        $appleTree = new Plant(
            'Pommier',
            'Malus',
            '',
            $this->getPlantFamily($manager, 'fructable'),
            12
        );
        $appleTree->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 11, 2));
        $appleTree->addPreferedSoilType($this->getSoilType($manager, 'limestone'));
        $appleTree->addPreferedSoilType($this->getSoilType($manager, 'silica'));
        $appleTree->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $appleTree->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerType($manager, 'N-K'), 15));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerType($manager, 'N'), 9));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStep($manager, 'germing'), 9, 1));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStep($manager, 'growth'), 1095, 2));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStep($manager, 'pollinate'), 15, 3));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStep($manager, 'flowering'), 7, 4));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStep($manager, 'fruct'), 90, 5));

        $carrot = new Plant(
            'Carotte',
            'Daucus carota',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $carrot->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 4, 7));
        $carrot->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 7));
        $carrot->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 6));
        $carrot->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $carrot->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $carrot->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $carrot->addPreferedFertilizerType(new PlantFertilizerType($carrot, $this->getFertilizerType($manager, 'K-P'), 15));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStep($manager, 'germing'), 30, 1));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStep($manager, 'growth'), 150, 2));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStep($manager, 'harvest'), 7, 3));

        $radish = new Plant(
            'Radis',
            'Raphanus sativus',
            '',
            $this->getPlantFamily($manager, 'eatable'),
            12
        );
        $radish->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 4, 6));
        $radish->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 6));
        $radish->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 3, 5));
        $radish->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $radish->addPreferedSoilType($this->getSoilType($manager, 'sand'));
        $radish->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $radish->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $radish->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));
        $radish->addPreferedFertilizerType(new PlantFertilizerType($radish, $this->getFertilizerType($manager, 'K-P'), 15));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStep($manager, 'germing'), 8, 1));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStep($manager, 'growth'), 120, 2));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStep($manager, 'harvest'), 7, 3));

        $geranium = new Plant(
            'Géranium',
            'Geranium',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $geranium->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 10));
        $geranium->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 5, 10));
        $geranium->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 9));
        $geranium->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $geranium->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $geranium->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));
        $geranium->addPreferedSunExposureType($this->getSunExposureType($manager, 'shadow'));
        $geranium->addPreferedFertilizerType(new PlantFertilizerType($geranium, $this->getFertilizerType($manager, 'K'), 15));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStep($manager, 'germing'), 8, 1));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStep($manager, 'growth'), 90, 2));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStep($manager, 'flowering'), 180, 3));

        $daffodil = new Plant(
            'Jonquille véritable',
            'Narcissus jonquilla',
            '',
            $this->getPlantFamily($manager, 'flower'),
            12
        );
        $daffodil->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 6));
        $daffodil->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 10, 5));
        $daffodil->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 9, 4));
        $daffodil->addPreferedSoilType($this->getSoilType($manager, 'clay'));
        $daffodil->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));
        $daffodil->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));

        $fir = new Plant(
            'Sapin',
            'Abies',
            '',
            $this->getPlantFamily($manager, 'other'),
            1
        );
        $fir->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 11));
        $fir->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 10));
        $fir->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 10));
        $fir->addPreferedSoilType($this->getSoilType($manager, 'humus'));
        $fir->addPreferedSunExposureType($this->getSunExposureType($manager, 'sun'));

        $fern = new Plant(
            'Fougère',
            'Filicophyta',
            '',
            $this->getPlantFamily($manager, 'other'),
            12
        );
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 5, 11));
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 4, 10));
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 4, 10));
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-n', 11, 5));
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-m', 10, 4));
        $fern->addPlantingDateInterval($this->getPlantingDateInterval($manager, 'fra-s', 10, 4));
        $fern->addPreferedSoilType($this->getSoilType($manager, 'peaty'));
        $fern->addPreferedSunExposureType($this->getSunExposureType($manager, 'shadow'));
        $fern->addPreferedSunExposureType($this->getSunExposureType($manager, 'half-sun'));

        foreach ([$tomato, $appleTree, $carrot, $radish, $geranium, $daffodil, $fir, $fern] as $obj) {
            $manager->persist($obj);
        }

        $manager->flush();
    }
}