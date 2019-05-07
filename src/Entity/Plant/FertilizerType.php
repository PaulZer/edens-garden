<?php

namespace App\Entity\Plant;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, message="There is already a FertilizerType with this code.")
 */
class FertilizerType
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
     * One Plant may have Many FertilizerType.
     * @ORM\OneToMany(targetEntity="PlantFertilizerType", mappedBy="fertilizer")
     */
    private $plantFertilizerTypes;

    /**
     * FertilizerType constructor.
     */
    public function __construct(string $name, string $code, string $description)
    {
        $this->name = $name;
        $this->code = $code;
        $this->description = $description;
        $this->plantFertilizerTypes = new ArrayCollection();
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
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
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|PlantFertilizerType[]
     */
    public function getPlantFertilizerTypes(): Collection
    {
        return $this->plantFertilizerTypes;
    }

    public function getSpecimenFertilizerTypes(Plant $reference):PlantFertilizerType
    {
        foreach($this->plantFertilizerTypes as $plantFertilizerType){
            if($plantFertilizerType->getPlant() == $reference){
                return $plantFertilizerType;
            }
        }
        return null;
    }

    public function addPlantFertilizerType(PlantFertilizerType $plantFertilizerType): self
    {
        if (!$this->plantFertilizerTypes->contains($plantFertilizerType)) {
            $this->plantFertilizerTypes[] = $plantFertilizerType;
            $plantFertilizerType->setFertilizer($this);
        }

        return $this;
    }

    public function removePlantFertilizerType(PlantFertilizerType $plantFertilizerType): self
    {
        if ($this->plantFertilizerTypes->contains($plantFertilizerType)) {
            $this->plantFertilizerTypes->removeElement($plantFertilizerType);
            // set the owning side to null (unless already changed)
            if ($plantFertilizerType->getFertilizer() === $this) {
                $plantFertilizerType->setFertilizer(null);
            }
        }

        return $this;
    }
}