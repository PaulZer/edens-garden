<?php

namespace App\Entity\Plant;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, message="There is already a SoilType with this code.")
 */
class SoilType
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
     * One Plant may have Many SoilType.
     * @ORM\OneToMany(targetEntity="PlantSoilType", mappedBy="soilType")
     */
    private $plantSoilTypes;

    /**
     * SoilType constructor.
     * @param $name
     * @param $code
     * @param $description
     * @param $plantSoilType
     */
    public function __construct(string $name,string $code,string $description)
    {
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;
        $this->plantSoilTypes = new ArrayCollection();
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
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }



    public function addPlantSoilType(PlantSoilType $plantSoilType): self
    {
        if (!$this->plantSoilTypes->contains($plantSoilType)) {
            $this->plantSoilTypes[] = $plantSoilType;
            $plantSoilType->setSoilType($this);
        }

        return $this;
    }

    public function removePlantSoilType(PlantSoilType $plantSoilType): self
    {
        if ($this->plantSoilTypes->contains($plantSoilType)) {
            $this->plantSoilTypes->removeElement($plantSoilType);
            // set the owning side to null (unless already changed)
            if ($plantSoilType->getSoilType() === $this) {
                $plantSoilType->getSoilType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlantSoilType[]
     */
    public function getPlantSoilTypes(): Collection
    {
        return $this->plantSoilTypes;
    }

}