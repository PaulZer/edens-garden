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
class PlantFertilizer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * One Plant Fertilizer is relative to One Plant.
     * @ORM\OneToOne(targetEntity="Plant")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * One Plant Fertilizer is relative to One Fertilizer.
     * @ORM\OneToOne(targetEntity="Fertilizer")
     * @ORM\JoinColumn(name="fertilizer_id", referencedColumnName="id")
     */
    private $fertilizer;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbDayBeforeFertilizing;

    /**
     * PlantFertilizer constructor.
     * @param $id
     * @param $plant
     * @param $fertilizer
     * @param $nbDayBeforeFertilizing
     */
    public function __construct(string $id, Plant $plant, Fertilizer $fertilizer, int $nbDayBeforeFertilizing)
    {
        $this->id = $id;
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
     * @return Fertilizer
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


}