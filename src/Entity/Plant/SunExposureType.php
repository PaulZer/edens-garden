<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 09:27
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, message="There is already a SunExposureType with this code.")
 */
class SunExposureType
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
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * One Plant may have Many SunExposureType.
     * @ORM\OneToMany(targetEntity="PlantSunExposureType", mappedBy="sunExposureType")
     */
    private $plantSunExposureType;

    /**
     * SunExposureType constructor.
     * @param $id
     * @param $name
     */
    public function __construct(string $name, string $code, string $description)
    {
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;
        $this->plantSunExposureType = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return Collection|PlantSunExposureType[]
     */
    public function getPlantSunExposureType()
    {
        return $this->plantSunExposureType;
    }

    public function addPlantSunExposureType(PlantSunExposureType $plantSunExposureType): self
    {
        if (!$this->plantSunExposureType->contains($plantSunExposureType)) {
            $this->plantSunExposureType[] = $plantSunExposureType;
            $plantSunExposureType->setSunExposureType($this);
        }

        return $this;
    }

    public function removePlantSunExposureType(PlantSunExposureType $plantSunExposureType): self
    {
        if ($this->plantSunExposureType->contains($plantSunExposureType)) {
            $this->plantSunExposureType->removeElement($plantSunExposureType);
            // set the owning side to null (unless already changed)
            if ($plantSunExposureType->getSunExposureType() === $this) {
                $plantSunExposureType->getSunExposureType(null);
            }
        }

        return $this;
    }

}