<?php

namespace App\Entity\Plant;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlantRepository")
 */
class Plant
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="latin_name")
     */
    private $latinName;

    /**
     * @ORM\Column(type="string", name="picture_path")
     */
    private $picturePath;

    /**
     * @ORM\ManyToOne(targetEntity="PlantFamily")
     * @ORM\JoinColumn(name="plant_family_id", referencedColumnName="id")
     */
    private $plantFamily;

    /**
     * @ORM\Column(type="integer", name="water_frequency")
     */
    private $waterFrequency;

    /**
     * One Plant may have Many PlantSunExposureType.
     * @ORM\OneToMany(targetEntity="PlantSunExposureType", mappedBy="plant", cascade={"persist"})
     */
    private $preferedSunExposureTypes;

    /**
     * One Plant may have Many PlantSoilType.
     * @ORM\OneToMany(targetEntity="PlantSoilType", mappedBy="plant", cascade={"persist"})
     */
    private $preferedSoilTypes;

    /**
     * One Plant may have Many PlantFertilizerType.
     * @ORM\OneToMany(targetEntity="PlantFertilizerType", mappedBy="plant", cascade={"persist"})
     */
    private $preferedFertilizerTypes;

    /**
     * One Plant may have Many LifeCycleStep.
     * @ORM\OneToMany(targetEntity="PlantLifeCycleStep", mappedBy="plant", cascade={"persist"})
     */
    private $lifeCycleSteps;

    /**
     * Many Plant may have Many PlantingDateInterval.
     * @ORM\ManyToMany(targetEntity="PlantingDateInterval", cascade={"persist"})
     * @ORM\JoinTable(name="plant_planting_date_interval",
     *      joinColumns={@ORM\JoinColumn(name="plant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="planting_date_interval_id", referencedColumnName="id")}
     *      )
     */
    private $plantingDateIntervals;

    /**
     * Plant constructor.
     * @param $name
     * @param $latinName
     * @param $picturePath
     * @param $picturePath
     * @param $waterFrequency
     */
    public function __construct(string $name, string $latinName, string $picturePath, int $waterFrequency)
    {
        $this->name = $name;
        $this->latinName = $latinName;
        $this->picturePath = $picturePath;
        $this->waterFrequency = $waterFrequency;
        $this->preferedSunExposureTypes = new ArrayCollection();
        $this->preferedSoilTypes = new ArrayCollection();
        $this->preferedFertilizerTypes = new ArrayCollection();
        $this->plantingDateIntervals = new ArrayCollection();
        $this->lifeCycleSteps = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getLatinName()
    {
        return $this->latinName;
    }

    /**
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * @return PlantFamily
     */
    public function getPlantFamily()
    {
        return $this->plantFamily;
    }

    /**
     * @return int
     */
    public function getWaterFrequency()
    {
        return $this->waterFrequency;
    }

    /**
     * @return \App\Entity\Plant\PlantSunExposureType[]
     */
    public function getPreferedSunExposureTypes()
    {
        return $this->preferedSunExposureTypes;
    }

    /**
     * @return \App\Entity\Plant\PlantSoilType[]
     */
    public function getPreferedSoilTypes()
    {
        return $this->preferedSoilTypes;
    }

    /**
     * @return \App\Entity\Plant\PlantingDateInterval[]
     */
    public function getPlantingDateIntervals()
    {
        return $this->plantingDateIntervals;
    }


    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setLatinName(string $latinName): self
    {
        $this->latinName = $latinName;

        return $this;
    }

    public function setPicturePath(string $picturePath): self
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    public function setWaterFrequency(int $waterFrequency): self
    {
        $this->waterFrequency = $waterFrequency;

        return $this;
    }

    public function setPlantFamily(?PlantFamily $plantFamily): self
    {
        $this->plantFamily = $plantFamily;

        return $this;
    }

    public function addPreferedSunExposureType(PlantSunExposureType $preferedSunExposureType): self
    {
        if (!$this->preferedSunExposureTypes->contains($preferedSunExposureType)) {
            $this->preferedSunExposureTypes[] = $preferedSunExposureType;
        }

        return $this;
    }

    public function removePreferedSunExposureType(PlantSunExposureType $preferedSunExposureType): self
    {
        if ($this->preferedSunExposureTypes->contains($preferedSunExposureType)) {
            $this->preferedSunExposureTypes->removeElement($preferedSunExposureType);
        }

        return $this;
    }

    public function addPreferedSoilType(PlantSoilType $preferedSoilType): self
    {
        if (!$this->preferedSoilTypes->contains($preferedSoilType)) {
            $this->preferedSoilTypes[] = $preferedSoilType;
        }

        return $this;
    }

    public function removePreferedSoilType(PlantSoilType $preferedSoilType): self
    {
        if ($this->preferedSoilTypes->contains($preferedSoilType)) {
            $this->preferedSoilTypes->removeElement($preferedSoilType);
        }

        return $this;
    }

    public function addPlantingDateInterval(PlantingDateInterval $plantingDateInterval): self
    {
        if (!$this->plantingDateIntervals->contains($plantingDateInterval)) {
            $this->plantingDateIntervals[] = $plantingDateInterval;
        }

        return $this;
    }

    public function removePlantingDateInterval(PlantingDateInterval $plantingDateInterval): self
    {
        if ($this->plantingDateIntervals->contains($plantingDateInterval)) {
            $this->plantingDateIntervals->removeElement($plantingDateInterval);
        }

        return $this;
    }

    public function getPreferedFertilizerTypes(): Collection
    {
        return $this->preferedFertilizerTypes;
    }

    public function addPreferedFertilizerType(PlantFertilizerType $preferedFertilizerType): self
    {
        if (!$this->preferedFertilizerTypes->contains($preferedFertilizerType)) {
            $this->preferedFertilizerTypes[] = $preferedFertilizerType;
        }

        return $this;
    }

    public function removePreferedFertilizerType(PlantFertilizerType $preferedFertilizerType): self
    {
        if ($this->preferedFertilizerTypes->contains($preferedFertilizerType)) {
            $this->preferedFertilizerTypes->removeElement($preferedFertilizerType);
        }

        return $this;
    }

    /**
     * @return Collection|PlantLifeCycleStep[]
     */
    public function getLifeCycleSteps(): Collection
    {
        return $this->lifeCycleSteps;
    }

    public function addLifeCycleStep(PlantLifeCycleStep $lifeCyclestep): self
    {
        if (!$this->lifeCycleSteps->contains($lifeCyclestep)) {
            $this->lifeCycleSteps[] = $lifeCyclestep;
            $lifeCyclestep->setPlant($this);
        }

        return $this;
    }

    public function removeLifeCycleStep(PlantLifeCycleStep $lifeCyclestep): self
    {
        if ($this->lifeCycleSteps->contains($lifeCyclestep)) {
            $this->lifeCycleSteps->removeElement($lifeCyclestep);
            // set the owning side to null (unless already changed)
            if ($lifeCyclestep->getPlant() === $this) {
                $lifeCyclestep->setPlant(null);
            }
        }

        return $this;
    }
}