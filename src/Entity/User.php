<?php

namespace App\Entity;

use App\Entity\Garden\Garden;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * Many User may have Many Garden.
     * @ORM\OneToMany(targetEntity="App\Entity\Garden\Garden", mappedBy="user")
     */
    private $gardens;

    /**
     * @ORM\Column(type="boolean",nullable=false,options={"default":true},name="want_feedback")
     */
    private $wantFeedBack;

    /**
     * @ORM\Column(type="integer",nullable=false,options={"default":7},name="days_between_feedback")
     */
    private $daysBetweenFeedBack;

    /**
     * @ORM\Column(type="datetime", name ="last_feedback_date")
     */
    private $lastFeedBackDate;

    public function __construct()
    {
        $this->gardens = new ArrayCollection();
        $this->lastFeedBackDate = new \DateTimeImmutable('now');
    }

    public function getWantFeedBack()
    {
        return $this->wantFeedBack;
    }

    public function setWantFeedBack($wantFeedback)
    {
        $this->wantFeedBack = $wantFeedback;
    }

    public function getDaysBetweenFeedBack()
    {
        return $this->daysBetweenFeedBack;
    }

    public function setDaysBetweenFeedBack($daysBetweenFeedBack)
    {
        $this->daysBetweenFeedBack = $daysBetweenFeedBack;
    }

    public function getLastFeedBackDate()
    {
        return $this->lastFeedBackDate;
    }

    public function setLastFeedBackdate($lastFeedBackDate)
    {
        $this->lastFeedBackDate = $lastFeedBackDate;
    }

    /**
     * @return \App\Entity\Garden\Garden[]
     */
    public function getGardens()
    {
        return $this->gardens;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string)$this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function addGarden(Garden $garden): self
    {
        if (!$this->gardens->contains($garden)) {
            $this->gardens[] = $garden;
        }

        return $this;
    }

    public function removeGarden(Garden $garden): self
    {
        if ($this->gardens->contains($garden)) {
            $this->gardens->removeElement($garden);
        }

        return $this;
    }

}
