<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 13/03/2019
 * Time: 13:56
 */

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
     * One PlantLifeCycleStep is relative to One Plant.
     * @ORM\OneToOne(targetEntity="Plant")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * One PlantLifeCycleStep is relative to One LifeCycleStep.
     * @ORM\OneToOne(targetEntity="LifeCycleStep")
     * @ORM\JoinColumn(name="life_cycle_step_id", referencedColumnName="id")
     */
    private $lifeCycleStep;

    /**
     * @ORM\Column(type="integer", name="nb_day_from_previous_step")
     */
    private $nbDayFromPreviousStep;

    /**
     * @ORM\Column(type="integer")
     */
    private $order;

    /**
     * PlantLifeCycleStep constructor.
     * @param $plant
     * @param $lifeCycleStep
     * @param $nbDayFromPreviousStep
     * @param $order
     */
    public function __construct(Plant $plant, LifeCycleStep $lifeCycleStep, int $nbDayFromPreviousStep, int $order)
    {
        $this->plant = $plant;
        $this->lifeCycleStep = $lifeCycleStep;
        $this->nbDayFromPreviousStep = $nbDayFromPreviousStep;
        $this->order = $order;
    }

    /**
     * @return string
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
    public function getNbDayFromPreviousStep()
    {
        return $this->nbDayFromPreviousStep;
    }

    /**
     * @param int $nbDayFromPreviousStep
     */
    public function setNbDayFromPreviousStep(int $nbDayFromPreviousStep): void
    {
        $this->nbDayFromPreviousStep = $nbDayFromPreviousStep;
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



}