<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:09
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Util\Month;

/**
 * @ORM\Entity
 */
class PlantingDateInterval
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Util\Month")
     * @ORM\JoinColumn(name="id_month_begin", referencedColumnName="id")
     */
    private $monthBegin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Util\Month")
     * @ORM\JoinColumn(name="id_month_end", referencedColumnName="id")
     */
    private $monthEnd;

    /**
     * @ORM\ManyToOne(targetEntity="ClimaticArea")
     * @ORM\JoinColumn(name="id_climatic_area", referencedColumnName="id")
     */
    private $climaticArea;

    /**
     * PlantingDateInterval constructor.
     * @param $id
     * @param $monthBegin
     * @param $monthEnd
     * @param $climaticArea
     */
    public function __construct(string $id, Month $monthBegin, Month $monthEnd, ClimaticArea $climaticArea)
    {
        $this->id = $id;
        $this->monthBegin = $monthBegin;
        $this->monthEnd = $monthEnd;
        $this->climaticArea = $climaticArea;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Month
     */
    public function getMonthBegin()
    {
        return $this->monthBegin;
    }

    /**
     * @return Month
     */
    public function getMonthEnd()
    {
        return $this->monthEnd;
    }

    /**
     * @return ClimaticArea
     */
    public function getClimaticArea()
    {
        return $this->climaticArea;
    }


}