<?php
/**
 * Created by PhpStorm.
 * User: lp
 * Date: 22/02/2019
 * Time: 11:12
 */

namespace App\Entity\Util;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"num"}, message="There is already a Month with this num.")
 */
class Month
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
     * @ORM\Column(type="integer", name="num", unique=true)
     */
    private $num;

    /**
     * Month constructor.
     * @param $name
     * @param $num
     */
    public function __construct(string $name, int $num)
    {
        $this->name = $name;
        $this->num = $num;
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

    public function getNum(): ?int
    {
        return $this->num;
    }

    public function setNum(int $num): self
    {
        $this->num = $num;

        return $this;
    }


}