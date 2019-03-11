<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 09:16
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
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
     * Many Plant may have Many SunExposureType.
     * @ORM\ManyToMany(targetEntity="SunExposureType")
     * @ORM\JoinTable(name="plant_sun_exposure_type",
     *      joinColumns={@ORM\JoinColumn(name="plant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="sun_exposure_type_id", referencedColumnName="id")}
     *      )
     */
    private $preferedSunExposureTypes;

    /**
     * Many Plant may have Many SoilType.
     * @ORM\ManyToMany(targetEntity="SoilType")
     * @ORM\JoinTable(name="plant_soil_type",
     *      joinColumns={@ORM\JoinColumn(name="plant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="soil_type_id", referencedColumnName="id")}
     *      )
     */
    private $preferedSoilTypes;

    /**
     * Many Plant may have Many PlantingDateInterval.
     * @ORM\ManyToMany(targetEntity="PlantingDateInterval")
     * @ORM\JoinTable(name="plant_planting_date_interval",
     *      joinColumns={@ORM\JoinColumn(name="plant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="planting_date_interval_id", referencedColumnName="id")}
     *      )
     */
    private $plantingDateIntervals;

    /**
     * Many Plant may have Many LifeCycleStep.
     * @ORM\ManyToMany(targetEntity="LifeCycleStep")
     * @ORM\JoinTable(name="plant_life_cycle_step",
     *      joinColumns={@ORM\JoinColumn(name="plant_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="life_cycle_step_id", referencedColumnName="id")}
     *      )
     */
    private $lifeCycleSteps;

    /**
     * Plant constructor.
     * @param $id
     * @param $name
     * @param $latinName
     * @param $picturePath
     * @param $plantFamily
     * @param $waterFrequency
     * @param $preferedSunExposureTypes
     * @param $preferedSoilTypes
     * @param $plantingDateIntervals
     * @param $lifeCycleSteps
     */
    public function __construct(string $id,string $name,string $latinName,string $picturePath,PlantFamily $plantFamily,int $waterFrequency)
    {
        $this->id = $id;
        $this->name = $name;
        $this->latinName = $latinName;
        $this->picturePath = $picturePath;
        $this->plantFamily = $plantFamily;
        $this->waterFrequency = $waterFrequency;
        $this->preferedSunExposureTypes = new ArrayCollection();
        $this->preferedSoilTypes = new ArrayCollection();
        $this->plantingDateIntervals = new ArrayCollection();
        $this->lifeCycleSteps = new ArrayCollection();
    }

    /**
     * @return string
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
     * @return \App\Entity\Plant\SunExposureType[]
     */
    public function getPreferedSunExposureTypes()
    {
        return $this->preferedSunExposureTypes;
    }

    /**
     * @return \App\Entity\Plant\SoilType[]
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

    /**
     * @return \App\Entity\Plant\LifeCycleStep[]
     */
    public function getLifeCycleSteps()
    {
        return $this->lifeCycleSteps;
    }

}