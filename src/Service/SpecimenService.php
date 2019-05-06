<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 20/03/2019
 * Time: 16:02
 */

namespace App\Service;


use App\Entity\API\CurrentWeather;
use App\Entity\Garden\Garden;
use App\Entity\Garden\Plot;
use App\Entity\Garden\Specimen;
use App\Entity\Garden\SpecimenLifeResult;
use App\Entity\Plant\FertilizerType;
use App\Entity\Util\LogEvent;
use App\Repository\SpecimenRepository;
use Doctrine\Common\Persistence\ObjectManager;

class SpecimenService
{
    private $specimenRepository;
    private $om;

    /**
     * SpecimenService constructor.
     * @param $specimenRepository
     */
    public function __construct(SpecimenRepository $specimenRepository, ObjectManager $objectManager)
    {
        $this->specimenRepository = $specimenRepository;
        $this->om = $objectManager;
    }

    private function updateSpecimen(Specimen $specimen)
    {
        $this->om->persist($specimen);
        $this->om->flush();
    }

    public function setFertilizer(int $specimenId, int $fertilizerId, \DateTimeImmutable $today)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $fertilizer = $this->om->getRepository(FertilizerType::class)->findOneBy(['id' => $fertilizerId]);
        $specimen->setFertilizer($fertilizer);
        $specimen->setLastFertilizedDate($today);
        $specimen->addLog(new LogEvent("Fertilize", "La plante a été fertilisé avec " . $specimen->getFertilizer()->getName(), $specimen->getLastFertilizedDate()));
        $this->updateSpecimen($specimen);
    }

    public function fertilize(int $specimenId, \DateTimeImmutable $today)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastFertilizedDate($today);
        $specimen->addLog(new LogEvent("Fertilize", "La plante a été fertilisé avec " . $specimen->getFertilizer()->getName(), $specimen->getLastFertilizedDate()));
        $this->updateSpecimen($specimen);
    }

    public function waterize(int $specimenId, bool $weather, \DateTimeImmutable $today)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastWateredDate($today);
        if ($weather == false)
            $specimen->addLog(new LogEvent("Waterize", "La plante a été arrosé", $specimen->getLastWateredDate()));
        else
            $specimen->addLog(new LogEvent("Waterize", "La plante a été arrosé par la pluie", $specimen->getLastWateredDate()));

        $this->updateSpecimen($specimen);
    }

    public function waterizePlot(int $plotId, bool $weather, \DateTimeImmutable $today)
    {
        $plot = $this->om->getRepository(Plot::class)->findOneBy(['id' => $plotId]);
        foreach ($plot->getSpecimens() as $specimen) {
            $this->waterize($specimen->getId(), $weather, $today);
        }
    }

    public function waterizeGarden(int $gardenId, bool $weather, \DateTimeImmutable $today)
    {
        $garden = $this->om->getRepository(Garden::class)->findOneBy(['id' => $gardenId]);
        foreach ($garden->getPlots() as $plot) {
            $this->waterizePlot($plot->getId(), $weather, $today);
        }
    }

    public function goToNextLifeCycleStep(int $specimenId, \DateTimeImmutable $today)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $currentLifeCycleStep = $specimen->getCurrentLifeCycleStep();
        $defaultsLifeCycleStep = $specimen->getPlant()->getLifeCycleSteps();
        foreach ($defaultsLifeCycleStep as $lifeCycleStep) {
            if ($lifeCycleStep->getOrder() == $currentLifeCycleStep->getOrder() + 1) {
                $specimen->setCurrentLifeCycleStep($lifeCycleStep);
                $specimen->addLog(new LogEvent("Next Life Cycle Step", "La plante est passé à sa prochaine étape de cycle de vie", $today));
                $this->updateSpecimen($specimen);
            }
        }
    }

    public function goToLifeCycleStep(int $specimenId, int $order, \DateTimeImmutable $today)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $defaultsLifeCycleStep = $specimen->getPlant()->getLifeCycleSteps();
        foreach ($defaultsLifeCycleStep as $lifeCycleStep) {
            if ($lifeCycleStep->getOrder() == $order) {
                $specimen->setCurrentLifeCycleStep($lifeCycleStep);
            }
        }
        $specimen->addLog(new LogEvent("Set Specific Life Cycle Step", "La cycle de vie de la plante actuel a été modifié à " . $specimen->getCurrentLifeCycleStep()->getName() . " step", $today));
        $this->updateSpecimen($specimen);
    }

    public function hourlyWeatherResult(int $specimenId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimenLat = $specimen->getPlot()->getGarden()->getLatitude();
        $specimenLn = $specimen->getPlot()->getGarden()->getLongitude();
        $currentWeatherProvider = new CurrentWeather(strval($specimenLat), strval($specimenLn),"41483201f4e8d0ac0d8fd986ac4adb01");
        $currentWeatherData = $currentWeatherProvider->getCurrentWeatherData();
        $currentWeather = $currentWeatherProvider->formatCurrentWeatherArray($currentWeatherData);
        if ($currentWeather['rain_1h'] > 2) {
            $now = new \DateTimeImmutable('now');
            $this->waterize($specimenId, true, $now);
        } else {
            return false;
        }
    }

    public function allSpecimensHourlyWeatherResult()
    {
        $gardens = $this->om->getRepository(Garden::class)->findAll();
        foreach ($gardens as $garden) {
            $currentWeatherProvider = new CurrentWeather(strval($garden->getLatitude()), strval($garden->getLongitude()), "41483201f4e8d0ac0d8fd986ac4adb01");
            $currentWeatherData = $currentWeatherProvider->getCurrentWeatherData();
            $currentWeather = $currentWeatherProvider->formatCurrentWeatherArray($currentWeatherData);
            if ($currentWeather['rain_1h'] > 0.5) {
                $now = new \DateTimeImmutable('now');
                $this->waterizeGarden($garden->getId(), true, $now);
            }
        }
    }

    public function dailyLifeResultForAllSpecimen(\DateTimeImmutable $today)
    {
        $specimens = $this->specimenRepository->findAll();

        foreach ($specimens as $specimen) {

            if (!$specimen->getLastWateredDate()) {
                $waterEfficiency = 0;
            } else {
                $daysWithoutWater = $specimen->getLastWateredDate()->diff($today)->days;
                $specimenWaterFrequency = $specimen->getPlant()->getWaterFrequency();
                $waterEfficiency = 100;
                if ($specimenWaterFrequency < $daysWithoutWater)
                    $waterEfficiency = $waterEfficiency - (($daysWithoutWater - $specimenWaterFrequency) * $waterEfficiency / $specimenWaterFrequency);
            }

            if (!$specimen->getLastFertilizedDate()) {
                $fertilizerEfficiency = 0;
            } else {
                $daysSinceLastFertilizing = $specimen->getLastFertilizedDate()->diff($today)->days;
                $specimenPlantFertilizerType = $specimen->getFertilizer()->getSpecimenFertilizerTypes($specimen->getPlant());
                $fertilizerFrequency = $specimenPlantFertilizerType->getNbDayBeforeFertilizing();
                $fertilizerEfficiency = $this->specimenRepository->getSpecimenFertilizerTypeEfficiency($specimen);
                if ($fertilizerFrequency < $daysSinceLastFertilizing)
                    $fertilizerEfficiency = $fertilizerEfficiency - (($daysSinceLastFertilizing - $fertilizerFrequency) * $fertilizerEfficiency / $fertilizerFrequency);
            }

            $soilEfficiency = $this->specimenRepository->getSpecimenSoilTypeEfficiency($specimen);
            $sunExposureEfficiency = $this->specimenRepository->getSpecimenSunExposureTypeEfficiency($specimen);
            $specimen->addSpecimenLifeResult(new SpecimenLifeResult($waterEfficiency, $fertilizerEfficiency, $soilEfficiency, $sunExposureEfficiency, $today, $specimen));

            $this->updateSpecimen($specimen);
        }
    }
}