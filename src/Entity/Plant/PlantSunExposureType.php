<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 18/03/2019
 * Time: 09:55
 */

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
     * @ORM\JoinColumn(name="soil_type_id", referencedColumnName="id")
     */
    private $sunExposureType;

    /**
     * @ORM\Column(type="integer")
     */
    private $efficiency;

    /**
     * PlantSunExposureType constructor.
     * @param $plant
     * @param $sunExposureType
     * @param $efficiency
     */
    public function __construct(Plant $plant,SunExposureType $sunExposureType,int $efficiency)
    {
        $this->plant = $plant;
        $this->sunExposureType = $sunExposureType;
        $this->efficiency = $efficiency;
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