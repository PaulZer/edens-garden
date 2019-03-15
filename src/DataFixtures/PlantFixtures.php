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
    private $manager = null;

    public function getPlantFamilyByCode($code): PlantFamily
    {
        return $this->manager->getRepository("App\Entity\Plant\PlantFamily")->findOneBy(array('code' => $code));
    }

    public function getClimaticAreaByCode(string $code): ClimaticArea
    {
        return $this->manager->getRepository("App\Entity\Plant\ClimaticArea")->findOneBy(array('code' => $code));
    }

    public function getSoilTypeByCode(string $code): SoilType
    {
        return $this->manager->getRepository("App\Entity\Plant\SoilType")->findOneBy(array('code' => $code));
    }

    public function getSunExposureTypeByCode(string $code): SunExposureType
    {
        return $this->manager->getRepository("App\Entity\Plant\SunExposureType")->findOneBy(array('code' => $code));
    }

    public function getFertilizerTypeByCode(string $code): FertilizerType
    {
        return $this->manager->getRepository("App\Entity\Plant\FertilizerType")->findOneBy(array('code' => $code));
    }

    public function getLifeCycleStepByCode(string $code): LifeCycleStep
    {
        return $this->manager->getRepository("App\Entity\Plant\LifeCycleStep")->findOneBy(array('code' => $code));
    }

    public function getPlantingDateIntervalByCode(string $climaticAreaCode, int $numMonthBegin, int $numMonthEnd): PlantingDateInterval
    {
        $monthBegin = $this->manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthBegin));
        $monthEnd = $this->manager->getRepository("App\Entity\Util\Month")->findOneBy(array('num' => $numMonthEnd));
        return $this->manager->getRepository("App\Entity\Plant\PlantingDateInterval")->findOneBy(array(
            'climaticArea' => $this->getClimaticAreaByCode($climaticAreaCode),
            'monthBegin' => $monthBegin,
            'monthEnd' => $monthEnd
        ));
    }

    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        $tomato = new Plant(
            'Plant de tomate',
            'Solanum lycopersicum',
            '',
            $this->getPlantFamilyByCode( 'fructable'),
            12
        );
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 6));
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 5));
        $tomato->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 3, 4));
        $tomato->addPreferedSoilType($this->getSoilTypeByCode( 'humus'));
        $tomato->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $tomato->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $tomato->addPreferedFertilizerType(new PlantFertilizerType($tomato, $this->getFertilizerTypeByCode( 'N-K'), 9));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'germing'), 9, 1));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'growth'), 120, 2));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'flowering'), 7, 3));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'fruct'), 45, 4));
        $tomato->addLifeCycleStep(new PlantLifeCycleStep($tomato, $this->getLifeCycleStepByCode( 'harvest'), 7, 5));

        $appleTree = new Plant(
            'Pommier',
            'Malus',
            '',
            $this->getPlantFamilyByCode( 'fructable'),
            12
        );
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 11, 2));
        $appleTree->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 11, 2));
        $appleTree->addPreferedSoilType($this->getSoilTypeByCode( 'limestone'));
        $appleTree->addPreferedSoilType($this->getSoilTypeByCode( 'silica'));
        $appleTree->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $appleTree->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerTypeByCode( 'N-K'), 15));
        $appleTree->addPreferedFertilizerType(new PlantFertilizerType($appleTree, $this->getFertilizerTypeByCode( 'N'), 9));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'germing'), 9, 1));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'growth'), 1095, 2));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'pollinate'), 15, 3));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'flowering'), 7, 4));
        $appleTree->addLifeCycleStep(new PlantLifeCycleStep($appleTree, $this->getLifeCycleStepByCode( 'fruct'), 90, 5));

        $carrot = new Plant(
            'Carotte',
            'Daucus carota',
            '',
            $this->getPlantFamilyByCode( 'eatable'),
            12
        );
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 3, 4));
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 3, 4));
        $carrot->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 2, 3));
        $carrot->addPreferedSoilType($this->getSoilTypeByCode( 'humus'));
        $carrot->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $carrot->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $carrot->addPreferedFertilizerType(new PlantFertilizerType($carrot, $this->getFertilizerTypeByCode( 'K-P'), 15));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'germing'), 30, 1));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'growth'), 150, 2));
        $carrot->addLifeCycleStep(new PlantLifeCycleStep($carrot, $this->getLifeCycleStepByCode( 'harvest'), 7, 3));

        $radish = new Plant(
            'Radis',
            'Raphanus sativus',
            '',
            $this->getPlantFamilyByCode( 'eatable'),
            12
        );
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 3, 5));
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 3, 5));
        $radish->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 2, 4));
        $radish->addPreferedSoilType($this->getSoilTypeByCode( 'humus'));
        $radish->addPreferedSoilType($this->getSoilTypeByCode( 'sand'));
        $radish->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $radish->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $radish->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'half-sun'));
        $radish->addPreferedFertilizerType(new PlantFertilizerType($radish, $this->getFertilizerTypeByCode( 'K-P'), 15));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'germing'), 8, 1));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'growth'), 120, 2));
        $radish->addLifeCycleStep(new PlantLifeCycleStep($radish, $this->getLifeCycleStepByCode( 'harvest'), 7, 3));

        $geranium = new Plant(
            'Géranium',
            'Geranium',
            '',
            $this->getPlantFamilyByCode( 'flower'),
            12
        );
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 4, 5));
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 5));
        $geranium->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 3, 4));
        $geranium->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $geranium->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $geranium->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'half-sun'));
        $geranium->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'shadow'));
        $geranium->addPreferedFertilizerType(new PlantFertilizerType($geranium, $this->getFertilizerTypeByCode( 'K'), 15));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'germing'), 8, 1));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'growth'), 90, 2));
        $geranium->addLifeCycleStep(new PlantLifeCycleStep($geranium, $this->getLifeCycleStepByCode( 'flowering'), 180, 3));

        $daffodil = new Plant(
            'Jonquille véritable',
            'Narcissus jonquilla',
            '',
            $this->getPlantFamilyByCode( 'flower'),
            12
        );
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 10, 11));
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 9, 10));
        $daffodil->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 9, 10));
        $daffodil->addPreferedSoilType($this->getSoilTypeByCode( 'humus'));
        $daffodil->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $daffodil->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $daffodil->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'half-sun'));
        $daffodil->addPreferedFertilizerType(new PlantFertilizerType($daffodil, $this->getFertilizerTypeByCode( 'N'), 15));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'germing'), 90, 1));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'growth'), 90, 2));
        $daffodil->addLifeCycleStep(new PlantLifeCycleStep($daffodil, $this->getLifeCycleStepByCode( 'flowering'), 21, 3));

        $fir = new Plant(
            'Sapin',
            'Abies',
            '',
            $this->getPlantFamilyByCode( 'other'),
            1
        );
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 11));
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 10));
        $fir->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 4, 10));
        $fir->addPreferedSoilType($this->getSoilTypeByCode( 'clay'));
        $fir->addPreferedSoilType($this->getSoilTypeByCode( 'humus'));
        $fir->addPreferedSoilType($this->getSoilTypeByCode( 'sand'));
        $fir->addPreferedSoilType($this->getSoilTypeByCode( 'limestone'));
        $fir->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'sun'));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'K'), 15));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'N-K'), 15));
        $fir->addPreferedFertilizerType(new PlantFertilizerType($fir, $this->getFertilizerTypeByCode( 'K-P'), 15));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'germing'), 180, 1));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'growth'), 730, 2));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'pollinate'), 30, 3));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'flowering'), 90, 4));
        $fir->addLifeCycleStep(new PlantLifeCycleStep($fir, $this->getLifeCycleStepByCode( 'fruct'), 180, 5));

        $fern = new Plant(
            'Fougère',
            'Filicophyta',
            '',
            $this->getPlantFamilyByCode( 'other'),
            12
        );
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-n', 5, 11));
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-m', 4, 10));
        $fern->addPlantingDateInterval($this->getPlantingDateIntervalByCode( 'fra-s', 4, 10));
        $fern->addPreferedSoilType($this->getSoilTypeByCode( 'peaty'));
        $fern->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'shadow'));
        $fern->addPreferedSunExposureType($this->getSunExposureTypeByCode( 'half-sun'));
        $fern->addPreferedFertilizerType(new PlantFertilizerType($fern, $this->getFertilizerTypeByCode( 'N'), 15));
        $fern->addLifeCycleStep(new PlantLifeCycleStep($fern, $this->getLifeCycleStepByCode( 'germing'), 180, 1));
        $fern->addLifeCycleStep(new PlantLifeCycleStep($fern, $this->getLifeCycleStepByCode( 'growth'), 3650, 2));

        foreach ([$tomato, $appleTree, $carrot, $radish, $geranium, $daffodil, $fir, $fern] as $obj) {
            $manager->persist($obj);
        }

        $manager->flush();
    }
}