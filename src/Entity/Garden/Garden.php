<?php

namespace App\Entity\Garden;

use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Util\Country;
/**
 * @ORM\Entity
 */
class Garden
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
    private $latitude;

    /**
     * @ORM\Column(type="float")
     */
    private $longitude;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Util\Country")
     * @ORM\JoinColumn(name="country_id", referencedColumnName="id")
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @ORM\Column(type="integer")
     */
    private $length;

    /**
     * One Garden has many plots. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Plot", mappedBy="garden", cascade={"persist"})
     */
    private $plots;

    /**
     * Many User may have Many Garden.
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="gardens")
     */
    private $user;

    /**
     * Garden constructor.
     * @param $name
     * @param $latitude
     * @param $longitude
     * @param $country
     * @param $height
     * @param $length
     * @param $plots
     */
    public function __construct(User $user, string $name,float $latitude,float $longitude,float $height,float $length)
    {
        $this->user = $user;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->height = $height;
        $this->length = $length;
        $this->plots = new ArrayCollection();
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
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
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
     * @return \App\Entity\Garden\Plot[]
     */
    public function getPlots()
    {
        return $this->plots;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function setHeight(int $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function setLength(int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function addPlot(Plot $plot): self
    {
        if (!$this->plots->contains($plot)) {
            $this->plots[] = $plot;
            $plot->setGarden($this);
        }

        return $this;
    }

    public function removePlot(Plot $plot): self
    {
        if ($this->plots->contains($plot)) {
            $this->plots->removeElement($plot);
            // set the owning side to null (unless already changed)
            if ($plot->getGarden() === $this) {
                $plot->setGarden(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}