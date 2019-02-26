<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:17
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class ClimaticArea
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
     * @ORM\Column(type="float", name="max_latitude")
     */
    private $maxLatitude;

    /**
     * @ORM\Column(type="float", name="min_latitude")
     */
    private $minLatitude;

    /**
     * ClimaticArea constructor.
     * @param $id
     * @param $name
     * @param $maxLatitude
     * @param $minLatitude
     */
    public function __construct(string $id, string $name, float $maxLatitude, float $minLatitude)
    {
        $this->id = $id;
        $this->name = $name;
        $this->maxLatitude = $maxLatitude;
        $this->minLatitude = $minLatitude;
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
     * @return float
     */
    public function getMaxLatitude()
    {
        return $this->maxLatitude;
    }

    /**
     * @return float
     */
    public function getMinLatitude()
    {
        return $this->minLatitude;
    }


}