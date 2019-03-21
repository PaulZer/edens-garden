<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 18/03/2019
 * Time: 09:42
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlantSoilType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many PlantSoilType is relative to One Plant.
     * @ORM\ManyToOne(targetEntity="Plant", inversedBy="preferedSoilTypes")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * Many PlantSoilType is relative to One SoilType.
     * @ORM\ManyToOne(targetEntity="SoilType", inversedBy="plantSoilType")
     * @ORM\JoinColumn(name="soil_type_id", referencedColumnName="id")
     */
    private $soilType;

    /**
     * @ORM\Column(type="integer")
     */
    private $efficiency;

    /**
     * PlantSoilType constructor.
     * @param $plant
     * @param $soilType
     * @param $efficiency
     */
    public function __construct(Plant $plant,SoilType $soilType,int $efficiency)
    {
        $this->plant = $plant;
        $this->soilType = $soilType;
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
     * @return SoilType
     */
    public function getSoilType()
    {
        return $this->soilType;
    }

    /**
     * @param mixed $soilType
     */
    public function setSoilType($soilType): void
    {
        $this->soilType = $soilType;
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