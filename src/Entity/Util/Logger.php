<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 20/03/2019
 * Time: 14:12
 */

namespace App\Entity\Util;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Logger
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * One Logger has many logs. This is the inverse side.
     * @ORM\OneToMany(targetEntity="LogEvent", mappedBy="parent")
     */
    private $logs;

    /**
     * Logger constructor.
     */
    public function __construct()
    {
        $this->logs = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return \App\Entity\Util\LogEvent[]
     */
    public function getLogs()
    {
        return $this->logs;
    }

    public function addLog(string $eventAction, string $eventMessage, \DateTimeImmutable $eventDate)
    {
        $this->logs->add(new LogEvent($eventAction, $eventMessage, $eventDate));
    }

    public function removeLog(LogEvent $log): self
    {
        if ($this->logs->contains($log)) {
            $this->logs->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getParent() === $this) {
                $log->setParent(null);
            }
        }

        return $this;
    }

}