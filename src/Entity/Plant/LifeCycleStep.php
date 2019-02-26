<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:53
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LifeCycleStep
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
     * @ORM\Column(type="integer")
     */
    private $order;

    /**
     * @ORM\Column(type="integer", name="nb_day_from_previous_step")
     */
    private $nbDayFromPreviousStep;

    /**
     * LifeCycleStep constructor.
     * @param $id
     * @param $name
     * @param $order
     * @param $nbDayFromPreviousStep
     */
    public function __construct(string $id, string $name, integer $order, integer $nbDayFromPreviousStep)
    {
        $this->id = $id;
        $this->name = $name;
        $this->order = $order;
        $this->nbDayFromPreviousStep = $nbDayFromPreviousStep;
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
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return integer
     */
    public function getNbDayFromPreviousStep()
    {
        return $this->nbDayFromPreviousStep;
    }


}