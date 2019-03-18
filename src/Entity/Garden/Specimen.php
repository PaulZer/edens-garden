<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/02/2019
 * Time: 12:41
 */

namespace App\Entity\Garden;

use App\Entity\Plant\LifeCycleStep;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Plant\Plant;
use App\Entity\Plant\FertilizerType;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SpecimenRepository")
 */
class Specimen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\Plant")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * @ORM\Column(type="datetime", name ="plantation_date")
     */
    private $plantationDate;

    /**
     * @ORM\Column(type="datetime", name ="last_watered_date")
     */
    private $lastWateredDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\FertilizerType")
     * @ORM\JoinColumn(name="fertilizer_id", referencedColumnName="id")
     */
    private $fertilizer;
    /**
     * @ORM\Column(type="datetime", name ="last_fertilized_date")
     */
    private $lastFertilizedDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\LifeCycleStep")
     * @ORM\JoinColumn(name="current_life_cycle_step_id", referencedColumnName="id")
     */
    private $currentLifeCycleStep;

    /**
     * Many specimens have one plot. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Plot", inversedBy="specimens")
     * @ORM\JoinColumn(name="plot_id", referencedColumnName="id")
     */
    private $plot;

    /**
     * Specimen constructor.
     * @param $id
     * @param $plant
     * @param $plantationDate
     * @param $lastWateredDate
     * @param $fertilizer
     * @param $lastFertilizedDate
     * @param $currentLifeCycleStep
     * @param $plot
     */
    public function __construct(string $id, Plant $plant, \DateTimeImmutable $plantationDate, \DateTimeImmutable $lastWateredDate, FertilizerType $fertilizer, \DateTimeImmutable $lastFertilizedDate, LifeCycleStep $currentLifeCycleStep, Plot $plot)
    {
        $this->id = $id;
        $this->plant = $plant;
        $this->plantationDate = $plantationDate;
        $this->lastWateredDate = $lastWateredDate;
        $this->fertilizer = $fertilizer;
        $this->lastFertilizedDate = $lastFertilizedDate;
        $this->currentLifeCycleStep = $currentLifeCycleStep;
        $this->plot = $plot;
    }

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
     * @return \DateTimeImmutable
     */
    public function getPlantationDate()
    {
        return $this->plantationDate;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastWateredDate()
    {
        return $this->lastWateredDate;
    }

    /**
     * @return FertilizerType
     */
    public function getFertilizer()
    {
        return $this->fertilizer;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getLastFertilizedDate()
    {
        return $this->lastFertilizedDate;
    }

    /**
     * @return LifeCycleStep
     */
    public function getCurrentLifeCycleStep()
    {
        return $this->currentLifeCycleStep;
    }

    /**
     * @return Plot
     */
    public function getPlot()
    {
        return $this->plot;
    }

    public function setPlantationDate(\DateTimeInterface $plantationDate): self
    {
        $this->plantationDate = $plantationDate;

        return $this;
    }

    public function setLastWateredDate(\DateTimeInterface $lastWateredDate): self
    {
        $this->lastWateredDate = $lastWateredDate;

        return $this;
    }

    public function setLastFertilizedDate(\DateTimeInterface $lastFertilizedDate): self
    {
        $this->lastFertilizedDate = $lastFertilizedDate;

        return $this;
    }

    public function setPlant(?Plant $plant): self
    {
        $this->plant = $plant;

        return $this;
    }

    public function setFertilizer(?FertilizerType $fertilizer): self
    {
        $this->fertilizer = $fertilizer;

        return $this;
    }

    public function setCurrentLifeCycleStep(?LifeCycleStep $currentLifeCycleStep): self
    {
        $this->currentLifeCycleStep = $currentLifeCycleStep;

        return $this;
    }

    public function setPlot(?Plot $plot): self
    {
        $this->plot = $plot;

        return $this;
    }


}