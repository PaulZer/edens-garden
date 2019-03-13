<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:17
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, message="There is already a ClimaticArea with this code.")
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
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

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
    public function __construct(string $name, string $code, float $maxLatitude, float $minLatitude)
    {
        $this->name = $name;
        $this->code = $code;
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setMaxLatitude(float $maxLatitude): self
    {
        $this->maxLatitude = $maxLatitude;

        return $this;
    }

    public function setMinLatitude(float $minLatitude): self
    {
        $this->minLatitude = $minLatitude;

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


}