<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/02/2019
 * Time: 12:32
 */

namespace App\Entity\Garden;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Plant\SunExposureType;
use App\Entity\Plant\SoilType;

/**
 * @ORM\Entity
 */
class Plot
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
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @ORM\Column(type="float")
     */
    private $length;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\SunExposureType")
     * @ORM\JoinColumn(name="sun_exposure_type_id", referencedColumnName="id")
     */
    private $sunExposureType;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\SoilType")
     * @ORM\JoinColumn(name="soil_type_id", referencedColumnName="id")
     */
    private $soilType;


    /**
     * One Plot has many specimens. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Specimen", mappedBy="plot")
     */
    private $specimens;

    /**
     * Many plots have one garden. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Garden", inversedBy="plots")
     * @ORM\JoinColumn(name="garden_id", referencedColumnName="id")
     */
    private $garden;

    /**
     * Plot constructor.
     * @param $id
     * @param $name
     * @param $height
     * @param $length
     * @param $sunExposureType
     * @param $soilType
     * @param $specimens
     * @param $garden
     */
    public function __construct(string $id,string $name,float $height,float $length,SunExposureType $sunExposureType,SoilType $soilType,Garden $garden)
    {
        $this->id = $id;
        $this->name = $name;
        $this->height = $height;
        $this->length = $length;
        $this->sunExposureType = $sunExposureType;
        $this->soilType = $soilType;
        $this->specimens = new ArrayCollection();
        $this->garden = $garden;
    }

    /**
     * @return int
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
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return SunExposureType
     */
    public function getSunExposureType()
    {
        return $this->sunExposureType;
    }

    /**
     * @return SoilType
     */
    public function getSoilType()
    {
        return $this->soilType;
    }

    /**
     * @return \App\Entity\Garden\Specimen[]
     */
    public function getSpecimens()
    {
        return $this->specimens;
    }

    /**
     * @return Garden
     */
    public function getGarden()
    {
        return $this->garden;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setLength(float $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function setSunExposureType(?SunExposureType $sunExposureType): self
    {
        $this->sunExposureType = $sunExposureType;

        return $this;
    }

    public function setSoilType(?SoilType $soilType): self
    {
        $this->soilType = $soilType;

        return $this;
    }

    public function addSpecimen(Specimen $specimen): self
    {
        if (!$this->specimens->contains($specimen)) {
            $this->specimens[] = $specimen;
            $specimen->setPlot($this);
        }

        return $this;
    }

    public function removeSpecimen(Specimen $specimen): self
    {
        if ($this->specimens->contains($specimen)) {
            $this->specimens->removeElement($specimen);
            // set the owning side to null (unless already changed)
            if ($specimen->getPlot() === $this) {
                $specimen->setPlot(null);
            }
        }

        return $this;
    }

    public function setGarden(?Garden $garden): self
    {
        $this->garden = $garden;

        return $this;
    }



}