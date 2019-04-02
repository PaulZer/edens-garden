<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/02/2019
 * Time: 12:41
 */

namespace App\Entity\Garden;

use App\Entity\Plant\LifeCycleStep;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Plant\Plant;
use App\Entity\Plant\FertilizerType;
use App\Entity\Util\Logger;

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
     * One Specimen has One Logger.
     * @ORM\OneToOne(targetEntity="App\Entity\Util\Logger")
     * @ORM\JoinColumn(name="logger_id", referencedColumnName="id")
     */
    private $logger;

    /**
     * One Specimen may have Many SpecimenLifeResult.
     * @ORM\OneToMany(targetEntity="SpecimenLifeResult", mappedBy="specimen", cascade={"persist"})
     */
    private $specimenLifeResults;
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
    public function __construct(Plant $plant, \DateTimeImmutable $plantationDate,  FertilizerType $fertilizer, Plot $plot)
    {
        $this->plant = $plant;
        $this->plantationDate = $plantationDate;
        $this->lastWateredDate = null;
        $this->fertilizer = $fertilizer;
        $this->lastFertilizedDate = null;
        $this->currentLifeCycleStep = $plant->getLifeCycleSteps()[0];
        $this->plot = $plot;
        $this->logger = new Logger();
        $this->specimenLifeResults = new ArrayCollection();
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

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger(?Logger $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * @return Collection|SpecimenLifeResult[]
     */
    public function getSpecimenLifeResults(): Collection
    {
        return $this->specimenLifeResults;
    }

    public function addSpecimenLifeResult(SpecimenLifeResult $specimenLifeResult): self
    {
        if (!$this->specimenLifeResults->contains($specimenLifeResult)) {
            $this->specimenLifeResults[] = $specimenLifeResult;
            $specimenLifeResult->setSpecimen($this);
        }

        return $this;
    }

    public function removeSpecimenLifeResult(SpecimenLifeResult $specimenLifeResult): self
    {
        if ($this->specimenLifeResults->contains($specimenLifeResult)) {
            $this->specimenLifeResults->removeElement($specimenLifeResult);
            // set the owning side to null (unless already changed)
            if ($specimenLifeResult->getSpecimen() === $this) {
                $specimenLifeResult->setSpecimen(null);
            }
        }

        return $this;
    }
}