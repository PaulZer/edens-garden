<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:42
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class PlantFertilizerType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Many PlantFertilizerType is relative to One Plant.
     * @ORM\ManyToOne(targetEntity="Plant", inversedBy="preferedFertilizerTypes")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * Many PlantFertilizerType is relative to One FertilizerType.
     * @ORM\ManyToOne(targetEntity="FertilizerType", inversedBy="plantFertilizerTypes")
     * @ORM\JoinColumn(name="fertilizer_type_id", referencedColumnName="id")
     */
    private $fertilizer;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDayBeforeFertilizing;

    /**
     * PlantFertilizerType constructor.
     * @param $id
     * @param $plant
     * @param $fertilizer
     * @param $nbDayBeforeFertilizing
     */
    public function __construct(Plant $plant, FertilizerType $fertilizer, int $nbDayBeforeFertilizing)
    {
        $this->plant = $plant;
        $this->fertilizer = $fertilizer;
        $this->nbDayBeforeFertilizing = $nbDayBeforeFertilizing;
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
     * @return FertilizerType
     */
    public function getFertilizer()
    {
        return $this->fertilizer;
    }

    /**
     * @return int
     */
    public function getNbDayBeforeFertilizing()
    {
        return $this->nbDayBeforeFertilizing;
    }

    public function setNbDayBeforeFertilizing(int $nbDayBeforeFertilizing): self
    {
        $this->nbDayBeforeFertilizing = $nbDayBeforeFertilizing;

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
}