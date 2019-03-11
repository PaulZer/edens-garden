<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/02/2019
 * Time: 11:57
 */

namespace App\Entity\Garden;

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
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @ORM\Column(type="float")
     */
    private $length;

    /**
     * One Garden has many plots. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Plot", mappedBy="garden")
     */
    private $plots;

    /**
     * Garden constructor.
     * @param $id
     * @param $name
     * @param $latitude
     * @param $longitude
     * @param $country
     * @param $height
     * @param $length
     * @param $plots
     */
    public function __construct(string $id,string $name,float $latitude,float $longitude,Country $country,float $height,float $length)
    {
        $this->id = $id;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->country = $country;
        $this->height = $height;
        $this->length = $length;
        $this->plots = new ArrayCollection();
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


}