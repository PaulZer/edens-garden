<?php

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlantSunExposureType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many PlantSoilType is relative to One Plant.
     * @ORM\ManyToOne(targetEntity="Plant", inversedBy="preferedSunExposureTypes")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * Many PlantSunExposureType is relative to One SunExposureType.
     * @ORM\ManyToOne(targetEntity="SunExposureType", inversedBy="plantSunExposureType")
     * @ORM\JoinColumn(name="sun_exposure_type_id", referencedColumnName="id")
     */
    private $sunExposureType;

    /**
     * @ORM\Column(type="integer")
     */
    private $efficiency;

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
     * @param mixed $plant
     */
    public function setPlant($plant): void
    {
        $this->plant = $plant;
    }

    /**
     * @return SunExposureType
     */
    public function getSunExposureType()
    {
        return $this->sunExposureType;
    }

    /**
     * @param mixed $sunExposureType
     */
    public function setSunExposureType($sunExposureType): void
    {
        $this->sunExposureType = $sunExposureType;
    }

    /**
     * @return int
     */
    public function getEfficiency()
    {
        return $this->efficiency;
    }

    /**
     * @param mixed $efficiency
     */
    public function setEfficiency($efficiency): void
    {
        $this->efficiency = $efficiency;
    }




}