<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:53
 */

namespace App\Entity\Plant;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"code"}, message="There is already a LifeCycleStep with this code.")
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
     * @ORM\Column(type="string", length=10, unique=true)
     */
    private $code;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

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

    public function __construct(string $name, string $order, string $code, string $description)
    {
        $this->name = $name;
        $this->order = $order;
        $this->code = $code;
        $this->description = $description;
        $this->nbDayFromPreviousStep = 0;
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

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setOrder(int $order): self
    {
        $this->order = $order;

        return $this;
    }

    public function setNbDayFromPreviousStep(int $nbDayFromPreviousStep): self
    {
        $this->nbDayFromPreviousStep = $nbDayFromPreviousStep;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }


}