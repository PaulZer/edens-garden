<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 20/03/2019
 * Time: 16:02
 */

namespace App\Service;


use App\Entity\API\CurrentWeather;
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

    public function setFertilizer(int $specimenId, int $fertilizerId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $fertilizer = $this->om->getRepository(FertilizerType::class)->findOneBy(['id' => $fertilizerId]);
        $specimen->setFertilizer($fertilizer);
        $specimen->setLastFertilizedDate(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        $specimen->addLog(new LogEvent("Fertilize", "The Plant has been Fertilized with " . $specimen->getFertilizer()->getName(), $specimen->getLastFertilizedDate()));
        $this->updateSpecimen($specimen);
    }

    public function fertilize(int $specimenId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastFertilizedDate(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        $specimen->addLog(new LogEvent("Fertilize", "The Plant has been Fertilized with " . $specimen->getFertilizer()->getName(), $specimen->getLastFertilizedDate()));
        $this->updateSpecimen($specimen);
    }

    public function waterize(int $specimenId, bool $weather)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastWateredDate(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        if ($weather == false)
            $specimen->addLog(new LogEvent("Waterize", "The Plant has been Waterized", $specimen->getLastWateredDate()));
        else
            $specimen->addLog(new LogEvent("Waterize", "The Plant has been Waterized by the rain", $specimen->getLastWateredDate()));

        $this->updateSpecimen($specimen);
    }

    public function goToNextLifeCycleStep(int $specimenId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $currentLifeCycleStep = $specimen->getCurrentLifeCycleStep();
        $defaultsLifeCycleStep = $specimen->getPlant()->getLifeCycleSteps();
        foreach ($defaultsLifeCycleStep as $lifeCycleStep) {
            if ($lifeCycleStep->getOrder() == $currentLifeCycleStep->getOrder() + 1) {
                $specimen->setCurrentLifeCycleStep($lifeCycleStep);
            }
        }
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $specimen->addLog(new LogEvent("Next Life Cycle Step", "The Plant has upgraded to the next life cycle step ", $now));
        $this->updateSpecimen($specimen);
    }

    public function goToLifeCycleStep(int $specimenId, int $order)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $defaultsLifeCycleStep = $specimen->getPlant()->getLifeCycleSteps();
        foreach ($defaultsLifeCycleStep as $lifeCycleStep) {
            if ($lifeCycleStep->getOrder() == $order) {
                $specimen->setCurrentLifeCycleStep($lifeCycleStep);
            }
        }
        $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
        $specimen->addLog(new LogEvent("Set Specific Life Cycle Step", "The Plant has been set to " . $specimen->getCurrentLifeCycleStep()->getName() . " step", $now));
        $this->updateSpecimen($specimen);
    }

    public function hourlyWeatherResult(int $specimenId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimenLat = $specimen->getPlot()->getGarden()->getLatitude();
        $specimenLn = $specimen->getPlot()->getGarden()->getLongitude();
        $currentWeatherProvider = new CurrentWeather(strval($specimenLat), strval($specimenLn));
        $currentWeather = $currentWeatherProvider->getCurrentWeatherData($currentWeatherProvider->getUrl());
        if ($currentWeather['rain_1h'] > 2) {
            return true;
        } else {
            return false;
        }
    }

    public function dailyLifeResultForAllSpecimen()
    {
        $specimens = $this->specimenRepository->findAll();

        foreach ($specimens as $specimen) {
            $now = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
            if (!$specimen->getLastWateredDate()) {
                $waterEfficiency = 0;
            } else {
                $daysWithoutWater = $specimen->getLastWateredDate()->diff($now)->days;
                $specimenWaterFrequency = $specimen->getPlant()->getWaterFrequency();
                $waterEfficiency = 100;
                if ($specimenWaterFrequency < $daysWithoutWater)
                    $waterEfficiency = $waterEfficiency - (($daysWithoutWater - $specimenWaterFrequency) * 100 / $specimenWaterFrequency);
            }
            $fertilizerEfficiency = $this->specimenRepository->getSpecimenFertilizerTypeEfficiency($specimen);
            $soilEfficiency = $this->specimenRepository->getSpecimenSoilTypeEfficiency($specimen);
            $sunExposureEfficiency = $this->specimenRepository->getSpecimenSunExposureTypeEfficiency($specimen);
            $specimen->addSpecimenLifeResult(new SpecimenLifeResult($waterEfficiency, $fertilizerEfficiency, $soilEfficiency, $sunExposureEfficiency, $now, $specimen));

            $this->updateSpecimen($specimen);
        }
    }
}