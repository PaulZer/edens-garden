<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 21/03/2019
 * Time: 15:46
 */

namespace App\Entity\Garden;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 */
class SpecimenLifeResult
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name ="water_efficiency")
     */
    private $waterEfficiency;

    /**
     * @ORM\Column(type="integer", name ="fertilizer_efficiency")
     */
    private $fertilizerEfficiency;

    /**
     * @ORM\Column(type="integer", name ="soil_efficiency")
     */
    private $soilEfficiency;

    /**
     * @ORM\Column(type="integer", name ="sun_exposure_efficiency")
     */
    private $sunExposureEfficiency;

    /**
     * @ORM\Column(type="datetime", name ="plantation_date")
     */
    private $date;

    /**
     * Many SpecimenLifeResult are relative to one Specimen.
     * @ORM\ManyToOne(targetEntity="Specimen", inversedBy="specimenLifeResults")
     * @ORM\JoinColumn(name="specimen_id", referencedColumnName="id")
     */
    private $specimen;

    /**
     * SpecimenLifeResult constructor.
     * @param $waterEfficiency
     * @param $fertilizerEfficiency
     * @param $soilEfficiency
     * @param $sunExposureEfficiency
     * @param $date
     * @param $specimen
     */
    public function __construct(int $waterEfficiency, int $fertilizerEfficiency, int $soilEfficiency, int $sunExposureEfficiency, \DateTimeImmutable $date, Specimen $specimen)
    {
        $this->waterEfficiency = $waterEfficiency;
        $this->fertilizerEfficiency = $fertilizerEfficiency;
        $this->soilEfficiency = $soilEfficiency;
        $this->sunExposureEfficiency = $sunExposureEfficiency;
        $this->date = $date;
        $this->specimen = $specimen;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getWaterEfficiency()
    {
        return $this->waterEfficiency;
    }

    /**
     * @param int $waterEfficiency
     */
    public function setWaterEfficiency($waterEfficiency): void
    {
        $this->waterEfficiency = $waterEfficiency;
    }

    /**
     * @return int
     */
    public function getFertilizerEfficiency()
    {
        return $this->fertilizerEfficiency;
    }

    /**
     * @param int $fertilizerEfficiency
     */
    public function setFertilizerEfficiency($fertilizerEfficiency): void
    {
        $this->fertilizerEfficiency = $fertilizerEfficiency;
    }

    /**
     * @return int
     */
    public function getSoilEfficiency()
    {
        return $this->soilEfficiency;
    }

    /**
     * @param int $soilEfficiency
     */
    public function setSoilEfficiency($soilEfficiency): void
    {
        $this->soilEfficiency = $soilEfficiency;
    }

    /**
     * @return int
     */
    public function getSunExposureEfficiency()
    {
        return $this->sunExposureEfficiency;
    }

    /**
     * @param int $sunExposureEfficiency
     */
    public function setSunExposureEfficiency($sunExposureEfficiency): void
    {
        $this->sunExposureEfficiency = $sunExposureEfficiency;
    }

    /**
     * @return int
     */
    public function getTotalEfficiency()
    {
        $totalEfficiency = ($this->waterEfficiency + $this->fertilizerEfficiency + $this->soilEfficiency + $this->sunExposureEfficiency) / 4;
        return $totalEfficiency;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTimeImmutable $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }


    /**
     * @return Specimen
     */
    public function getSpecimen()
    {
        return $this->specimen;
    }

    /**
     * @param Specimen $specimen
     */
    public function setSpecimen($specimen): void
    {
        $this->specimen = $specimen;
    }


}