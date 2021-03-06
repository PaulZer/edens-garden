<?php

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlantLifeCycleStep
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many PlantLifeCycleStep is relative to One Plant.
     * @ORM\ManyToOne(targetEntity="Plant", inversedBy="lifeCycleSteps")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * Many PlantLifeCycleStep is relative to One LifeCycleStep.
     * @ORM\ManyToOne(targetEntity="LifeCycleStep")
     * @ORM\JoinColumn(name="life_cycle_step_id", referencedColumnName="id")
     */
    private $lifeCycleStep;

    /**
     * @ORM\Column(type="integer", name="nb_day_from_previous_step")
     */
    private $stepDaysDuration;

    /**
     * @ORM\Column(type="integer", name="step_order")
     */
    private $order;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Plant
     */
    public function getPlant()
    {
        return $this->plant;
    }

    /**
     * @param Plant $plant
     */
    public function setPlant(Plant $plant): void
    {
        $this->plant = $plant;
    }

    /**
     * @return LifeCycleStep
     */
    public function getLifeCycleStep()
    {
        return $this->lifeCycleStep;
    }

    /**
     * @param LifeCycleStep $lifeCycleStep
     */
    public function setLifeCycleStep(LifeCycleStep $lifeCycleStep): void
    {
        $this->lifeCycleStep = $lifeCycleStep;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param int $order
     */
    public function setOrder(int $order): void
    {
        $this->order = $order;
    }

    public function getStepDaysDuration(): ?int
    {
        return $this->stepDaysDuration;
    }

    public function setStepDaysDuration(int $stepDaysDuration): self
    {
        $this->stepDaysDuration = $stepDaysDuration;

        return $this;
    }



}