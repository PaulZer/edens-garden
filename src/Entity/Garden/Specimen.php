<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 25/02/2019
 * Time: 12:41
 */

namespace App\Entity\Garden;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Plant\Plant;
use App\Entity\Plant\Fertilizer;

/**
 * @ORM\Entity
 */
class Specimen
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\Plant")
     * @ORM\JoinColumn(name="plant_id", referencedColumnName="id")
     */
    private $plant;

    /**
     * @ORM\Column(type="datetime", name ="plantation_date")
     */
    private $plantationDate;

    /**
     * @ORM\Column(type="datetime", name ="last_watered_date")
     */
    private $lastWateredDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\Fertilizer")
     * @ORM\JoinColumn(name="fertilizer_id", referencedColumnName="id")
     */
    private $fertilizer;
    /**
     * @ORM\Column(type="datetime", name ="last_fertilized_date")
     */
    private $lastFertilizedDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plant\LifeCycleStep")
     * @ORM\JoinColumn(name="current_life_cycle_step_id", referencedColumnName="id")
     */
    private $currentLifeCycleStep;

    /**
     * Many specimens have one plot. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Plot", inversedBy="specimens")
     * @ORM\JoinColumn(name="plot_id", referencedColumnName="id")
     */
    private $plot;
}