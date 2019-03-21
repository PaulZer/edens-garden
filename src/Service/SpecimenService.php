<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 20/03/2019
 * Time: 16:02
 */

namespace App\Service;


use App\Entity\Garden\Specimen;
use App\Repository\SpecimenRepository;
use Doctrine\ORM\EntityManager;

class SpecimenService
{
    private $specimenRepository;
    private $em;

    /**
     * SpecimenService constructor.
     * @param $specimenRepository
     */
    public function __construct(SpecimenRepository $specimenRepository, EntityManager $entityManager)
    {
        $this->specimenRepository = $specimenRepository;
        $this->em = $entityManager;
    }

    private function updateSpecimen(Specimen $specimen)
    {
        $this->em->persist($specimen);
        $this->em->flush();
    }

    public function fertilize(int $specimenId)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastFertilizedDate(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        $specimen->getLogger()->addLog("Fertilize", "The Plant has been Fertilized", $specimen->getLastFertilizedDate());

        $this->updateSpecimen($specimen);
    }

    public function waterize(int $specimenId, bool $weather)
    {
        $specimen = $this->specimenRepository->find($specimenId);
        $specimen->setLastWateredDate(new \DateTimeImmutable('now', new \DateTimeZone('UTC')));
        if ($weather == false)
            $specimen->getLogger()->addLog("Waterize", "The Plant has been Waterized", $specimen->getLastWateredDate());
        else
            $specimen->getLogger()->addLog("Waterize", "The Plant has been Waterized by the rain", $specimen->getLastWateredDate());

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

        $this->updateSpecimen($specimen);
    }
}