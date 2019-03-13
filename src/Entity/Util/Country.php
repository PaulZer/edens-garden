<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:13
 */

namespace App\Entity\Util;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Plant\ClimaticArea;

/**
 * @ORM\Entity
 */
class Country
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
     * One Country has One North Area.
     * @ORM\OneToOne(targetEntity="App\Entity\Plant\ClimaticArea")
     * @ORM\JoinColumn(name="north_area_id", referencedColumnName="id")
     */
    private $northArea;
    /**
     * One Country has One North Area.
     * @ORM\OneToOne(targetEntity="App\Entity\Plant\ClimaticArea")
     * @ORM\JoinColumn(name="middle_area_id", referencedColumnName="id")
     */
    private $middleArea;
    /**
     * One Country has One North Area.
     * @ORM\OneToOne(targetEntity="App\Entity\Plant\ClimaticArea")
     * @ORM\JoinColumn(name="south_area_id", referencedColumnName="id")
     */
    private $southArea;

    /**
     * Country constructor.
     * @param $id
     * @param $name
     * @param $northArea
     * @param $middleArea
     * @param $southArea
     */
    public function __construct(string $id, string $name, ClimaticArea $northArea, ClimaticArea $middleArea, ClimaticArea $southArea)
    {
        $this->id = $id;
        $this->name = $name;
        $this->northArea = $northArea;
        $this->middleArea = $middleArea;
        $this->southArea = $southArea;
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
     * @return ClimaticArea
     */
    public function getNorthArea()
    {
        return $this->northArea;
    }

    /**
     * @return ClimaticArea
     */
    public function getMiddleArea()
    {
        return $this->middleArea;
    }

    /**
     * @return ClimaticArea
     */
    public function getSouthArea()
    {
        return $this->southArea;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setNorthArea(?ClimaticArea $northArea): self
    {
        $this->northArea = $northArea;

        return $this;
    }

    public function setMiddleArea(?ClimaticArea $middleArea): self
    {
        $this->middleArea = $middleArea;

        return $this;
    }

    public function setSouthArea(?ClimaticArea $southArea): self
    {
        $this->southArea = $southArea;

        return $this;
    }


}