<?php

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Util\Month;

/**
 * @ORM\Entity
 */
class PlantingDateInterval
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Util\Month")
     * @ORM\JoinColumn(name="month_begin_id", referencedColumnName="id")
     */
    private $monthBegin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Util\Month")
     * @ORM\JoinColumn(name="month_end_id", referencedColumnName="id")
     */
    private $monthEnd;

    /**
     * @ORM\ManyToOne(targetEntity="ClimaticArea")
     * @ORM\JoinColumn(name="climatic_area_id", referencedColumnName="id")
     */
    private $climaticArea;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Month
     */
    public function getMonthBegin()
    {
        return $this->monthBegin;
    }

    /**
     * @return Month
     */
    public function getMonthEnd()
    {
        return $this->monthEnd;
    }

    /**
     * @return ClimaticArea
     */
    public function getClimaticArea()
    {
        return $this->climaticArea;
    }

    public function setMonthBegin(?Month $monthBegin): self
    {
        $this->monthBegin = $monthBegin;

        return $this;
    }

    public function setMonthEnd(?Month $monthEnd): self
    {
        $this->monthEnd = $monthEnd;

        return $this;
    }

    public function setClimaticArea(?ClimaticArea $climaticArea): self
    {
        $this->climaticArea = $climaticArea;

        return $this;
    }


}