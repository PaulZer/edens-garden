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

}