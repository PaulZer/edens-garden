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
}