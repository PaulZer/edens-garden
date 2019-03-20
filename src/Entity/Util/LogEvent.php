<?php
/**
 * Created by PhpStorm.
 * User: yoann
 * Date: 20/03/2019
 * Time: 14:15
 */

namespace App\Entity\Util;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class LogEvent
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", name ="event_action")
     */
    private $eventAction;

    /**
     * @ORM\Column(type="string", name ="event_message")
     */
    private $eventMessage;

    /**
     * @ORM\Column(type="datetime", name ="event_date")
     */
    private $eventDate;

    /**
     * Many LogEvent have one Logger. This is the owning side.
     * @ManyToOne(targetEntity="Logger", inversedBy="logs")
     * @JoinColumn(name="logger_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * LogEvent constructor.
     * @param $eventAction
     * @param $eventMessage
     * @param $eventDate
     */
    public function __construct(string $eventAction, string $eventMessage, \DateTimeImmutable $eventDate)
    {
        $this->eventAction = $eventAction;
        $this->eventMessage = $eventMessage;
        $this->eventDate = $eventDate;
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
    public function getEventAction()
    {
        return $this->eventAction;
    }

    /**
     * @param string $eventAction
     */
    public function setEventAction(string $eventAction): void
    {
        $this->eventAction = $eventAction;
    }

    /**
     * @return string
     */
    public function getEventMessage()
    {
        return $this->eventMessage;
    }

    /**
     * @param string $eventMessage
     */
    public function setEventMessage(string $eventMessage): void
    {
        $this->eventMessage = $eventMessage;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * @param \DateTimeImmutable $eventDate
     */
    public function setEventDate(\DateTimeImmutable $eventDate): void
    {
        $this->eventDate = $eventDate;
    }


}